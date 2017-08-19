<?php 

App::uses('ModelBehavior', 'Model');
App::uses('Message', 'Messages.Model');

class FieldMonitorBehavior extends ModelBehavior {
    
    /* 
        Sends an email to selected group of people when 
        certain fields are changed in the database. 
    
        Settings:
        
        - fields => array(); List of fields to monitor in the current model: [field => "Name"]. Set to 'false' for no field monitoring. 
        - onCreate => boolean; dispatch email if created.
        - onDelete => boolean; dispatch email if deleted.
        - emails => array; list of emails that will be notified.  
        - body => string; the body used for the email. 
        - subject => string; the subject line used for the email.
        
        Callbacks for the Model:
        
        - beforeEmail($settings = array()) => callback; Called before the email. Return false to stop. Return modified settings.
        - afterEmail($settings = array()) => callback; Called after the email is sent. Modified settings come in. Use for cleanup. 
    */
    
    // Default Data Structure //

        protected $defaults = array(
            'fields' => array(),
            'changes' => array(),
            'onCreate' => true,
            'onDelete' => true,
            'emails' => array(),
            'body' => "",
            'subject' => "A field has been changed."
        );
    
    // Live arrays //
    
        protected $changes = array(); 
        public $settings = array();
        
    // CakePHP Behavior Setup Function // 
    
        public function setup(Model $Model, $settings = array()) {
            $this->settings[$Model->alias] = array_merge($this->defaults, $settings);
            return parent::setup($Model, $settings); 
        }
    
    // CakePHP Behavior Callbacks //
    
        public function beforeSave($Model, $options = array()) {
            if(!empty($Model->data[$Model->alias]) && $Model->exists()) {
                $this->_field_check($Model);
            }       
            return parent::beforeSave($Model, $options);
        }
        
        public function afterSave($Model, $created, $options = array()) {
            $Model->read(); 
            if(!empty($created)) {
                $this->settings[$Model->alias]['changes'] = array('created' => true);
            }
            if( (!empty($created) && !empty($this->settings[$Model->alias]['onCreate'])) || (empty($created) && !empty($Model->data)) ) {
                $this->_dispatch_message($Model);
            }
            return parent::afterSave($Model, $created, $options);
        }
        
        public function beforeDelete($Model, $cascade = true) {
            if(!empty($this->settings[$Model->alias]['onDelete'])) { 
                $this->settings[$Model->alias]['changes'] = array('deleted' => true);
                $Model->read();
                $this->_dispatch_message($Model);
            }
            return parent::beforeDelete($Model, $cascade);
        }
    
    // Runs a per-field check on changes. Disables if `fields` is set to `false`. // 
    
        protected function _field_check($Model) {
            if(!empty($this->settings[$Model->alias]['fields'])) {
                foreach($this->settings[$Model->alias]['fields'] as $field => $name) {
                    $current = $Model->field($field);
                    if(!empty($Model->data[$Model->alias][$field]) && ($Model->data[$Model->alias][$field] != $current) ) {
                        $this->settings[$Model->alias]['changes'][$field] = array(
                            'name' => $name, 
                            'old' => $current, 
                            'new' => $Model->data[$Model->alias][$field]
                        );
                    } 
                }
            }
        }
        
    // Simple getter for the changes. Mainly for API stuff. 
    
        public function _get_field_changes($Model) {
            return $this->settings[$Model->alias]['changes']; 
        }
        
    // Render a View body for the email //
    
        public function renderEmailBody($Model, $view = "Messages.Messages\\field_monitor_email", $layout = "xml\default") {
            $body = new View(null);
            $body->set('settings', $this->settings[$Model->alias]);
            $body->set('model', $Model->alias);
            $body->set('data', $Model->data);
            return $this->settings[$Model->alias]['body'] = $body->render($view, $layout);
        }
    
    // Trigger Callbacks, dispatch email. //
    
        protected function _dispatch_message($Model) {
            
            if(method_exists($Model, 'beforeEmail')) {
                // Callback before email! //
                $this->settings[$Model->alias] = $Model->beforeEmail($this->settings[$Model->alias]);
            }
            
            if(empty($this->settings[$Model->alias])) {
                return false;
            }
            
            if(empty($this->settings[$Model->alias]['body'])) {
                $this->renderEmailBody($Model);
            }
            
            $message = new Message();
            $success = $message->push(
                $this->settings[$Model->alias]['body'],
                $this->settings[$Model->alias]['subject'],
                $this->settings[$Model->alias]['emails']
            );
            
            if(method_exists($Model, 'afterEmail')) {
                // Callback after email! //
                $Model->afterEmail($this->settings[$Model->alias]);
            }
            
            return $success;
        }
        
    // End //
}
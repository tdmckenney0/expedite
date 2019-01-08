<h1><?php echo h($this->request->data['Survey']['name']); ?></h1><?php // $this->log($this->request->data); ?>

<?php foreach($this->request->data['SurveySection'] as $section): ?>
    <fieldset>
        <legend><?php echo h($section['name']); ?></legend>
        <?php foreach($section['SurveyQuestion'] as $question): ?>
            <div class="span-11">
                
                <h4 style="min-height: 3em;"><?php echo h($question['question']); ?></h4>
                
                <div style="padding: 1em; ">
                    <?php echo $this->Form->create('SurveyQuestionResponse', array('inputDefaults' => $form_defaults, 'url' => array('plugin' => 'surveys', 'controller' => 'survey_question_responses', 'action' => 'add', $question['id'], 'ext' => 'json'))); ?>
                    
                        <?php if(!empty($question['SurveyQuestionResponse'])): ?>
                        
                            <?php $question['SurveyQuestionResponse'] = array_shift($question['SurveyQuestionResponse']); ?>
                            <?php echo $this->Form->input('response', array('type' => 'readonly', 'value' => $question['SurveyQuestionResponse']['response'])); ?>
                            
                        <?php elseif($question['SurveyQuestionType']['id'] == 1): ?>    
                    
                            <?php echo $this->Form->input('response', array('type' => 'select', 'empty' => ' - Choose - ', 'options' => $boolean));                             ?>
                        
                        <?php elseif($question['SurveyQuestionType']['id'] == 2): ?>
                        
                            <?php $choices = Hash::combine($question['SurveyQuestionChoice'], '{n}.id', '{n}.choice'); ?>
                        
                            <?php echo $this->Form->input('response', array(
                                    'type' => 'select',
                                    'style' => 'height: ' . count($choices) * 1.25 .  'em;',
                                    'multiple' => 'multiple',
                                    'options' => array_combine($choices, $choices)
                                )); 
                            ?>
                            
                            <?php //echo $this->Form->input('response_other', array('type' => 'text')); ?>
                            
                        <?php elseif($question['SurveyQuestionType']['id'] == 4): ?>
                        
                            <?php $choices = Hash::combine($question['SurveyQuestionChoice'], '{n}.id', '{n}.choice'); ?>
                            
                            <?php echo $this->Form->input('response', array('type' => 'select', 'empty' => ' - Choose - ', 'options' => array_combine($choices, $choices))); ?>
                            
                        <?php endif; ?>
                        
                    <?php echo $this->Form->end(); ?>
                </div>              
                   
                <hr />
            </div>
        <?php endforeach; ?>
    </fieldset>
<?php endforeach; ?>
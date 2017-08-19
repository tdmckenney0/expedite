<html>
    <head>
        <title></title>
    </head>
    <body>
        <?php if(!empty($settings['changes']['deleted'])): ?>
            <div><?php echo h($model); ?> has been deleted.</div>
         <?php elseif(!empty($settings['changes']['created'])): ?>
            <div><?php echo h($model); ?> has been added.</div>
        <?php elseif(!empty($settings['changes']['modified'])): ?>
            <div><?php echo h($model); ?> has been modified.</div>
        <?php elseif(!empty($settings['changes'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Field Name</th>
                        <th>Previous Value</th>
                        <th>New Value</th>    
                    </tr>    
                </thead>    
                <tbody>
                    <?php foreach($settings['changes'] as $field => $struct): ?>
                        <tr>
                            <td><?php echo h($struct['name']); ?></td>
                            <td><?php echo h($struct['old']); ?></td>
                            <td><?php echo h($struct['new']); ?></td>
                        </tr>
                    <?php endforeach; ?>    
                </tbody>
            </table>
        <?php endif; ?>
    </body>
</html>
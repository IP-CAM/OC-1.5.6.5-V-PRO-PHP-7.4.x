<?php if (!empty($data['added'])) { ?>
    <h2><?php echo $text_security_files_added; ?></h2>
    <table class="list" style="max-width:774px;">
        <thead>
            <tr>
                <td class="left"><?php echo $text_security_file; ?></td>
                <td><?php echo $text_security_modified; ?></td>
                <td><?php echo $text_security_file_hash; ?></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['added'] as $file => $attribute) { ?>
                <tr>
                    <td class="left" style="width:100%;word-break:break-all;"><?php echo $file; ?></td>
                    <td><pre><?php echo date('Y-m-d H:i:s', $attribute['mod_date']); ?></pre></td>
                    <td><pre><?php echo $attribute['hash']; ?></pre></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
<?php if (!empty($data['deleted'])) { ?>
    <h2><?php echo $text_security_files_deleted; ?></h2>
    <table class="list" style="max-width:774px;">
        <thead>
            <tr>
                <td class="left"><?php echo $text_security_file; ?></td>
                <td><?php echo $text_security_modified; ?></td>
                <td><?php echo $text_security_file_hash; ?></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['deleted'] as $file => $attribute) { ?>
                <tr>
                    <td class="left" style="width:100%;word-break:break-all;"><?php echo $file; ?></td>
                    <td><pre><?php echo date('Y-m-d H:i:s', $attribute['mod_date']); ?></pre></td>
                    <td><pre><?php echo $attribute['hash']; ?></pre></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
<?php if (!empty($data['changed'])) { ?>
    <h2><?php echo $text_security_files_changed; ?></h2>
    <table class="list" style="max-width:774px;">
        <thead>
            <tr>
                <td class="left"><?php echo $text_security_file; ?></td>
                <td><?php echo $text_security_modified; ?></td>
                <td><?php echo $text_security_file_hash; ?></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['changed'] as $file => $attribute) { ?>
                <tr>
                    <td class="left" style="width:100%;word-break:break-all;"><?php echo $file; ?></td>
                    <td><pre><?php echo date('Y-m-d H:i:s', $attribute['mod_date']); ?></pre></td>
                    <td><pre><?php echo $attribute['hash']; ?></pre></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
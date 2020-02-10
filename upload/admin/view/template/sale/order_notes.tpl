<?php if ($error) { ?>
<div class="warning"><?php echo $error; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<table class="notes list">
  <?php if(!isset($this->request->get['header']) || isset($this->request->get['header']) && $this->request->get['header'] == 'yes'): ?>
  <thead>
    <tr>
      <td class="center"><b><?php echo $column_date_added; ?></b></td>
      <td class="left"><b><?php echo $column_note; ?></b></td>
      <td class="center"><b><?php echo $column_done; ?></b></td>
      <td class="center"><b><?php echo $column_action; ?></b></td>
    </tr>
  </thead>
  <?php endif; ?>
  <tbody>
    <?php if ($notes) { ?>
      <?php foreach ($notes as $note) { ?>
        <?php if(!isset($this->request->get['header']) || isset($this->request->get['header']) && $this->request->get['header'] == 'yes' || $note['done'] == 0): ?>
      <tr>
        <td class="center"><?php echo $note['date_added']; ?></td>
        <td class="left"><?php echo $note['comment']; ?></td>
        <td class="center"><?php echo $note['done_text']; ?></td>
        <td class="center"><a class="button" href="<?php echo $note['action']; ?>"><?php echo $note['text_action']; ?></a></td>
      </tr>
        <?php endif; ?>
      <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<?php if(!isset($this->request->get['header']) || isset($this->request->get['header']) && $this->request->get['header'] == 'yes'): ?>
<div class="pagination"><?php echo $pagination; ?></div>
<?php endif; ?>
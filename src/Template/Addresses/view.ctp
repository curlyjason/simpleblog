array (
  'BelongsTo' => 
  array (
  ),
  'HasOne' => 
  array (
  ),
  'HasMany' => 
  array (
  ),
  'BelongsToMany' => 
  array (
  ),
)array (
)array (
)<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Address'), ['action' => 'edit', $address->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Address'), ['action' => 'delete', $address->id], ['confirm' => __('Are you sure you want to delete # {0}?', $address->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Addresses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Address'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="addresses view large-10 medium-9 columns">
    <h2><?= h($address->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Address') ?></h6>
            <p><?= h($address->address) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($address->id) ?></p>
            <h6 class="subheader"><?= __('User Id') ?></h6>
            <p><?= $this->Number->format($address->user_id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($address->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($address->modified) ?></p>
            <h6 class="subheader"><?= __('Updated') ?></h6>
            <p><?= h($address->updated) ?></p>
        </div>
    </div>
</div>

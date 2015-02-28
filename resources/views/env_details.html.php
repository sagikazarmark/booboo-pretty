<div class="details">
    <div class="data-table-container" id="data-tables">
        <?php foreach ($tables as $label => $data): ?>
            <div class="data-table" id="sg-<?php echo $this->escape($this->slug($label)) ?>">
                <label><?php echo $this->escape($label) ?></label>
                <?php if (!empty($data)): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <td class="data-table-k">Key</td>
                                    <td class="data-table-v">Value</td>
                                </tr>
                            </thead>
                        <?php foreach ($data as $k => $value): ?>
                            <tr>
                                <td><?php echo $this->escape($k) ?></td>
                                <td><?php echo $this->escape(print_r($value, true)) ?></td>
                            </tr>
                        <?php endforeach ?>
                        </table>
                <?php else: ?>
                    <span class="empty">empty</span>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    </div>
</div>

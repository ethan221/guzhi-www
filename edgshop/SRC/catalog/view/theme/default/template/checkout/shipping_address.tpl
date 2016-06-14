
        <?php if ($addresses) { ?>
        <?php foreach ($addresses as $address) { ?>
            <tr id="address-tr-<?php echo $address['address_id']; ?>">
                    <td><?php echo $address['fullname']; ?></td>
                    <td><?php echo $address['zone']; ?>，<?php echo $address['city']; ?>，<?php echo $address['region']; ?>，<?php echo $address['address']; ?></td>
                    <td><?php echo $address['shipping_telephone']; ?></td>
                    <td>
                        <?php if ($address['address_id'] == $address_id) { ?>
                        <button class="btn btn-default" disabled="disabled">默认地址</button>
                        <input type="radio" style="display: none" name="shipping_address" value="existing" checked="checked">
                        <input type="hidden" name="address_id" value="<?php echo $address_id;?>" />
                        <?php }else{ ?>
                        <button class="btn btn-red add-default-btn" data-loading-text="提交中......" onclick="addressButton.default(this,<?php echo $address['address_id']; ?>);">默认地址</button><button type="button" class="btn btn-link add-del-btn" data-toggle="modal" onclick="addressButton.setDelValue(<?php echo $address['address_id']; ?>);" data-target=".bs-example-modal-sm">删除</button>
                        <?php }?>
                    </td>
            </tr>
            <?php } ?>
            <?php } ?>
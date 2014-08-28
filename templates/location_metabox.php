<table>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="meta_a">Address 1</label>
        </th>
        <td>
            <input type="text" id="meta_a" name="meta_a" value="<?php echo @get_post_meta($post->ID, 'meta_a', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="meta_b">Address 2</label>
        </th>
        <td>
            <input type="text" id="meta_b" name="meta_b" value="<?php echo @get_post_meta($post->ID, 'meta_b', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="meta_c">City</label>
        </th>
        <td>
            <input type="text" id="meta_c" name="meta_c" value="<?php echo @get_post_meta($post->ID, 'meta_c', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="meta_d">State</label>
        </th>
        <td>
            <input type="text" id="meta_d" name="meta_d" value="<?php echo @get_post_meta($post->ID, 'meta_d', true); ?>" />
        </td>
    </tr>

    <tr valign="top">
        <th class="metabox_label_column">
            <label for="meta_e">ZIP</label>
        </th>
        <td>
            <input type="text" id="meta_e" name="meta_e" value="<?php echo @get_post_meta($post->ID, 'meta_e', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="meta_f">Phone 1</label>
        </th>
        <td>
            <input type="text" id="meta_f" name="meta_f" value="<?php echo @get_post_meta($post->ID, 'meta_f', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="meta_g">Phone 2</label>
        </th>
        <td>
            <input type="text" id="meta_g" name="meta_g" value="<?php echo @get_post_meta($post->ID, 'meta_g', true); ?>" />
        </td>
    </tr>
    <tr valign="top">
        <th class="metabox_label_column">
            <label for="meta_h">Alt. Email</label>
        </th>
        <td>
            <input type="text" id="meta_h" name="meta_h" value="<?php echo @get_post_meta($post->ID, 'meta_h', true); ?>" />
        </td>
    </tr>
</table>

<h3>Franchise Information</h3>
<table class="form-table">
    <tr>
        <th><label for="address1">Address 1</label></th>
        <td>
            <input type="text" name="address1" id="address1" value="<?php echo esc_attr( get_the_author_meta( 'meta', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Please enter your Address.</span>
        </td>
    </tr>
    <tr>
        <th><label for="address2">Address 2</label></th>
        <td>
            <input type="text" name="address2" id="address2" value="<?php echo esc_attr( get_the_author_meta( 'address2', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., Suite 200)</span>
        </td>
    </tr>
    <tr>
        <th><label for="city">City</label></th>
        <td>
            <input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"> </span>
        </td>
    </tr>
    <tr>
        <th><label for="state">State</label></th>
        <td>
            <input type="text" name="state" id="state" value="<?php echo esc_attr( get_the_author_meta( 'state', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., NY)</span>
        </td>
    </tr>
    <tr>
        <th><label for="zip">Postal Code</label></th>
        <td>
            <input type="text" name="zip" id="zip" value="<?php echo esc_attr( get_the_author_meta( 'zip', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., 10101)</span>
        </td>
    </tr>
</table>
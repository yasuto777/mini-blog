<!-- Author by Souma -->

<?php $this->setLayoutVar('title','パスワードの変更'); ?>

<h2>パスワードの変更</h2>
    ユーザーID：<strong><?php echo $user['user_name']; ?></strong>

    <form action="<?php echo $base_url; ?>/account/changepass" method="post">
        <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

    <?php if (isset($errors) && count($errors) > 0): ?>
    <?php echo $this->render('errors',array('errors' => $errors)); ?>
    <?php endif; ?>

    <table>
        <tbody>
            <tr>
                <th>Password</th>
                <td>
                    <input type="password" name="password" value="" />
                </td>
            </tr>
            <tr>
                <th>New Password</th>
                <td>
                <input type="password" name="new_password" value="" />
                </td>
            </tr>
            <tr>
                <th>New Password (again)</th>
                <td>
                    <input type="password" name="check_new_password" value="" />
                </td>
            </tr>
        </tbody>
    </table>

<p>
    <input type="submit" value="Update" />
</p>
</form>

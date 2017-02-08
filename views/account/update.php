<?php $this->setLayoutVar('title','パスワードの変更'); ?>

<h2>パスワードの変更</h2>
	ユーザーID：<?php echo $this->session->getPost['user_name']; ?>

	<form action="<?php echo $base_url; ?>/account/changepass" method="post">
		<input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

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

<?php

class StatusController extends Controller
{
	public function indexAction()
	{
		$user = $this->session->get('user');
		$status = $this->db_manager->get('Status')->fetchAllPersonalArchivesByUserId($user['id']);

		return $this->render(array(
			'statuses' => $statuses,
			'body' => '',
			'_token' => $this->generateCsrfToken('status/post'),
		));
	}
}

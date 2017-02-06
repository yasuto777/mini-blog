<?php

class StatusController extends Controller
{
	protected $auth_action = array('index','post');

	public function indexAction()
	{
		// Original Code
		// When visit top page,if you don't authenticated,redirect to the Signin page.
		if (!$this->session->isAuthenticated()){
			return $this->redirect('/account/signin');
		}
		// Original code end
		$user = $this->session->get('user');
		$statuses = $this->db_manager->get('Status')->fetchAllPersonalArchivesByUserId($user['id']);

		return $this->render(array(
			'statuses' => $statuses,
			'body' => '',
			'_token' => $this->generateCsrfToken('status/post'),
		));
	}
	#public function indexAction()
	#{
	#	$user = $this->session->get('user');
	#	$statuses = $this->db_manager->get('Status')->fetchAllPersonalArchivesByUserId($user['id']);

	#	return $this->render(array(
	#		'statuses' => $statuses,
	#		'body' => '',
	#		'_token' => $this->generateCsrfToken('status/post'),
	#	));
	#}

	public function postAction()
	{
		if (!$this->request->isPost()){
			$this->forward404();
		}

		$token = $this->request->getPost('_token');
		if (!$this->checkCsrfToken('status/post',$token)){
			return $this->redirect('/');
		}

		$body = $this->request->getPost('body');

		$errors = array();

		if (!strlen($body)){
			$errors[] = 'ひとことを入力してください';
		} else if (mb_strlen($body) > 200){
			$errors[] = 'ひとことは200文字以内で入力してください';
		}

		if (count($errors) === 0){
			$user = $this->session->get('user');
			$this->db_manager->get('Status')->insert($user['id'],$body);

			return $this->redirect('/');
		}

		$user = $this->session->get('user');
		$statuses = $this->db_manager->get('Status')->fetchAllPersonalArchivesByUserId($user['id']);

		return $this->render(array(
			'errors' => $errors,
			'body' => $body,
			'statuses' => $statuses,
			'_token' => $this->generateCsrfToken('status/post'),
		),'index');
	}

	public function userAction($params)
	{
		// getメソッドでユーザーを取得して、DB上のユーザー名と照合、結果を返してる
		$user = $this->db_manager->get('User')->fetchAllByUser($params['user_name']);
		if (!$user) {
			$this->forward404();
		}

		$statuses = $this->db_manager->get('Status')->fetchAllByUserId($user['id']);

		$following = null;
		if ($this->session->isAuthenticated()){
			$my = $this->session->get('user');
			if ($my['id'] !== $user['id']){
				$following = $this->db_manager->get('Following')->isFollowing($my['id'],$user['id']);
			}
		}

		return $this->render(array(
			'user' => $user,
			'status' => $statuses,
			'following' => $following,
			'_token' => $this->generateCsrfToken('account/follo'),
		));

	}

	public function showAction($params)
	{
		$status = $this->db_manager->get('Status')->fetchByIdAndUserName($params['id'],$params['user_name']);

		if (!$status){
			$this->forward404();
		}

		return $this->render(array('status' => $status));
	}
}

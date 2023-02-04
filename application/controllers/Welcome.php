<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url') ;
		$this->load->helper('form') ;
		$this->load->library('session') ;
	}

	public function index()
	{	
		$this->load->view('template-parts/header') ;
        $this->load->view('acceuil') ;
        $this->load->view('template-parts/footer') ;		
	}
	public function inscription() {
		$this->load->database() ;
        $this->load->library("form_validation") ;

		$this->form_validation->set_rules('mailRegister', 'E-mail', 'required');
		$this->form_validation->set_rules('nom', 'Name', 'required');
		$this->form_validation->set_rules('prenoms', 'Last name', 'required');
		$this->form_validation->set_rules('datedenaissance', 'Birthday', 'required');
		$this->form_validation->set_rules('age', 'Age', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		$pass = $this->input->post('password');
		// $password = sha256($pass);

		if($this->form_validation->run() === FALSE) {
			echo "Error";
		}	
		else {
			$this->db->insert('user',[
				"mail" => $this->input->post('mailRegister') ,
				"name" => $this->input->post('nom') ,
				"lastname" => $this->input->post('prenoms') ,
				"birthday" => $this->input->post('datedenaissance') ,
				"age" => $this->input->post('age') ,
				"password" => $pass ,
			]) ;
			echo "<script>alert('Données bien enregistrées');</script>" ;
			$this->index();
		}
	}
	public function loadHome() {

		$data["mydata"] = $this->affichage();
		$data["mydatas"] = $this->afficherCommentaires();
		$data["mydataLikes"] = $this->countLike();
		$data["mydataLikesColor"] = $this->colorLike();

		$this->load->view('template-parts/headerhome') ;	
		$this->load->view('home', $data);
		$this->load->view('template-parts/footerhome') ;
	}
	public function connexion() {
		$this->load->database() ;

		$this->db->where('mail', $this->input->post('mail'));
		$this->db->where('password', $this->input->post('motDePasse'));
		$mydata = $this->db->get("user");

		if($mydata->result() == NULL)
		{
			$this->index();
		}
		else 
		{
			foreach ($mydata->result() as $row)
			{
				$newdata = array(
					'userlastname'  => $row->lastname,
					'username'     => $row->name,
					'id' => $row->id,
				);
				$this->session->set_userdata($newdata) ;
				$this->loadHome();
			}			
		}
	} 
	public function deconnexion() {
		$this->index();	
		session_destroy();
	}
	public function publish() {
		$this->load->database() ;
		$this->load->library("form_validation") ;

		$this->form_validation->set_rules('comment', 'Comment', 'required');

		if($this->form_validation->run() === FALSE) {
			echo "<script>alert('Faites une publication');</script>";
			$this->loadHome();
		}	
		else {
			$this->db->insert('publication',[
				"pubValue" => $this->input->post('comment') ,
				"username" => $_SESSION['username'].' '.$_SESSION['userlastname'],
				"idusername" => $_SESSION['id'],
			]) ;
			$this->db->insert('likes',[
				"iduser" => $_SESSION['id'],
				// "idpub" => ,
				"color" => "red",
			]) ;
			$this->loadHome();
		}
	}
	public function affichage() {
		$this->load->database() ;
		$mydata = $this->db->get('publication') ; 

        return $mydata->result() ;
	}
	public function supprimer($id) {
		$this->load->database() ;

		$this->db->where('idusername', $_SESSION["id"] );
		$this->db->select('idusername') ;
		$data = $this->db->get('publication') ;

		$data1 = $data->result();
		
		for($i=0; $i<count($data1); $i++) {
			if($_SESSION["id"] == $data1[$i]->idusername) {
				$this->db->delete('publication', array('idPub'=> $id));

				$this->db->where('IdPub', $id);
				$this->db->delete('comments');

				$this->db->where('idpub', $id);
				$this->db->delete('likes');
			}
			else {
				echo "<script>alert('Vous ne pouvez pas effacer cette publication');</script>" ;
			}	
		}
		$this->loadHome();
	}
	public function comment() {
		$this->load->database() ;
		$this->load->library("form_validation") ;

		$this->form_validation->set_rules('comment', 'Commentaire', 'required');

		if($this->form_validation->run() === FALSE) {
			echo "<script>alert('Faites une publication');</script>";
			$this->loadHome();
		}
		else {
			$this->db->insert('comments',[
				"commentValue" => $this->input->post('comment') ,
				"commentOwner" => $this->input->post('commentOwner') ,
				"IdPub" => $this->input->post('idPublication') ,
			]) ;
			$this->loadHome();
		}	
	}
	public function afficherCommentaires() {
		$this->load->database() ;
		$mydatas = $this->db->get('comments') ;

		return $mydatas->result();
	}
	public function like($idPub) {
		$this->load->database() ;

		$this->db->where('idpub', $idPub);
		$this->db->where('iduser', $_SESSION['id']);
		$likes = $this->db->get('likes');
		$likes1 = $likes->result();

		if(count($likes1) == 0){
			$this->db->insert('likes', [
				"iduser" => $_SESSION['id'] ,
				"idpub" => $idPub ,
				"status" => "liked",
				"color" => "green",
			]);
		}
		else {
			for($i=0; $i<count($likes1); $i++) {
				if ($likes1[$i]->idpub == $idPub && $likes1[$i]->iduser == $_SESSION['id'] && $likes1[$i]->status == "liked") {
					$this->db->set('status', 'unliked');
					$this->db->set('color', 'red');
					$this->db->where('idpub', $idPub);
					$this->db->where('iduser', $_SESSION['id']);
					$this->db->update('likes');
				}
				else if($likes1[$i]->idpub == $idPub && $likes1[$i]->iduser == $_SESSION['id'] && $likes1[$i]->status == "unliked"){
					$this->db->set('status', 'liked');
					$this->db->set('color', 'green');
					$this->db->where('idpub', $idPub);
					$this->db->where('iduser', $_SESSION['id']);
					$this->db->update('likes');
				}
			}
		}
		$this->loadHome();
	}
	public function countLike() {
		$this->load->database() ;

		$this->db->where('status', 'liked');
		$mydataLikes = $this->db->get('likes') ;

		return $mydataLikes->result();
	}
	public function colorLike() {
		$this->db->where('iduser', $_SESSION['id']);
		
		$this->db->select('color');
		$mydataLikesColor = $this->db->get('likes') ;

		return $mydataLikesColor->result();
	}
}
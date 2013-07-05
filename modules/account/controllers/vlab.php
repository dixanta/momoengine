<?php
class Vlab extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->lang->module_load('account','account');
		$this->load->module_model('vlab','virtual_lab_model');
        
		$this->load->module_model('slug','slug_model');
		$this->bep_site->set_crumb('Home','');
		$this->bep_site->set_crumb('Account','account');
		$this->bep_site->set_crumb('Virtual Lab','vlab');
		$this->load->helper('easyui');
		$this->bep_assets->load_asset('tinymce');
	}

	public function index()
	{
		$data['header'] = "My Virtual Labe";
		$data['page'] =  'account/vlab/index';
		$data['vlabs']=$this->virtual_lab_model->getVirtualLabs(array('reg_user_id'=>$this->user_id,'delete_flag'=>0))->result_array();

		$this->load->view($this->_container,$data);
	}

	public function entry($virtual_lab_id= NULL)
	{
		if($virtual_lab_id)
		{
			$data=$this->virtual_lab_model->getVirtualLabs(array('virtual_lab_id'=>$virtual_lab_id))->row_array();
		}
		else
		{
			$data = $this->_default_values();
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('virtual_lab_name', 'Title', 'trim|required');
		$this->form_validation->set_rules('virtual_lab_description', 'Content', 'trim|required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$data['header'] = "New Virtual lab";
			$data['page'] =  'account/vlab/form';
			$data['module'] = 'vlab';
			$this->load->view($this->_container,$data);
		}
		else
		{
			$slug['slug_name'] = url_title($this->input->post('virtual_lab_name'), 'dash', TRUE);
			
			$postdata['virtual_lab_name']=$this->input->post('virtual_lab_name');
			$postdata['virtual_lab_description']=$this->input->post('virtual_lab_description');

			if(!$this->input->post('virtual_lab_id'))
			{
				$slug['slug_name']= $this->slug_model->validate_slug($slug['slug_name']);
				$this->slug_model->insert('SLUG',$slug);
					
				$postdata['slug_id'] = $this->db->insert_id();
				$postdata['slug_name'] = $slug['slug_name'];
			
				$postdata['reg_user_id'] = $this->user_id;
				$postdata['reg_timestamp']=date('Y-m-d H:i:s');
			
				$this->virtual_lab_model->insert('VIRTUAL_LAB',$postdata);
				$virtual_lab_id = $this->db->insert_id();
					
				$slug['route']='vlab/detail/'.$virtual_lab_id;
				$this->slug_model->update('SLUG',$slug,array('slug_id'=>$postdata['slug_id']));
				$this->session->set_flashdata('message','Virtual Lab added');
			}
			else
			{
				$slug_id = $this->input->post('slug_id');
				$slug['slug_name']= $this->slug_model->validate_slug($slug['slug_name'],$slug_id);
				$this->slug_model->update('SLUG',$slug,array('slug_id'=>$slug_id));
				
				$postdata['slug_name'] = $slug['slug_name'];
				
				$postdata['mod_user_id'] = $this->user_id;
				$postdata['mod_timestamp'] = date('Y-m-d H:i:s');
				$this->virtual_lab_model->update('VIRTUAL_LAB',$postdata,array('virtual_lab_id'=>$virtual_lab_id));
				$this->session->set_flashdata('message','Virtual Lab updated');
			}
			redirect(site_url('account/vlab'));
		}
	}

	private function _default_values()
	{
		$default = array();
		$default['virtual_lab_id'] = '';
		$default['virtual_lab_name'] = '';
		$default['virtual_lab_description'] = '';
		$default['slug_id'] = '';

		return $default;
	}

	public function delete($id = NULL)
	{
		if(is_null($id))
		{
			redirect(site_url('account/vlab'));
		}

		$vlab = $this->virtual_lab_model->getVirtualLabs(array('virtual_lab_id'=>$id))->row_array();
		
		$this->slug_model->delete_slug(array($vlab['slug_id'])); 
		$this->virtual_lab_model->delete('VIRTUAL_LAB',array('virtual_lab_id'=>$id));
		$this->session->set_flashdata('message','Your virtual lab has been deleted');
		redirect(site_url('account/vlab'));
	}

}
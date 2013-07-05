<?php 
class Network extends Member_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->lang->module_load('account','account');
		$this->load->module_model('network','network_model');
	
		$this->load->module_model('slug','slug_model');
		$this->bep_site->set_crumb('Home','');
		$this->bep_site->set_crumb('Account','account');
		$this->bep_site->set_crumb('Network','netwrok');
		
		/* $this->load->helper('easyui');
		$this->bep_assets->load_asset('tinymce');
		$this->bep_assets->load_asset('jquery.upload'); */
	}
	
	public function index()
	{
		$data['header'] = "My Entrepreneur";
		$data['page'] =  'account/network/index';
		$data['networks']=$this->network_model->getNetworks(array('user_id'=>$this->user_id))->result_array();
		
		$this->load->view($this->_container,$data);
	}
	
	public function entry($network_id= NULL)
	{
		if($network_id)
		{
			$data=$this->network_model->getNetworks(array('network_id'=>$network_id))->row_array();
		}
		else
		{
			$data = $this->_default_values();
		}
	
		$this->load->helper('form');
		$this->load->library('form_validation');
	
		$this->form_validation->set_rules('network_name', 'Network name', 'trim|required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$data['header'] = "New Network";
			$data['page'] =  'account/network/form';
			$data['module'] = 'network';
			$this->load->view($this->_container,$data);
		}
		else
		{
			$slug['slug_name'] = url_title($this->input->post('network_name'), 'dash', TRUE);
				
			$postdata['network_name']=$this->input->post('network_name');
		
			if(!$this->input->post('network_id'))
			{
				$slug['slug_name']= $this->slug_model->validate_slug($slug['slug_name']);
				$this->slug_model->insert('SLUG',$slug);
					
				$postdata['slug_id'] = $this->db->insert_id();
				$postdata['slug_name'] = $slug['slug_name'];
					
				$postdata['user_id'] = $this->user_id;
				$postdata['created_date']=date('Y-m-d H:i:s');
				$postdata['status'] = 1;
	
				$this->network_model->insert('NETWORKS',$postdata);
				$network_id = $this->db->insert_id();
					
				$slug['route']='entreprenuer/detail/'.$network_id;
				$this->slug_model->update('SLUG',$slug,array('slug_id'=>$postdata['slug_id']));
				
				$this->session->set_flashdata('message','Network added');
			}
			else
			{
				$slug_id = $this->input->post('slug_id');
				$slug['slug_name']= $this->slug_model->validate_slug($slug['slug_name'],$slug_id);
				$this->slug_model->update('SLUG',$slug,array('slug_id'=>$slug_id));
	
				$postdata['slug_name'] = $slug['slug_name'];
	
				$this->network_model->update('NETWORKS',$postdata,array('network_id'=>$network_id));
				$this->session->set_flashdata('message','Network post updated');
			}
			redirect(site_url('account/network'));
		}
	}
	
	private function _default_values()
	{
		$default = array();
		$default['network_id'] = '';
		$default['network_name'] = '';
		$default['slug_id'] = '';
	
		return $default;
	}
	
	public function delete($id = NULL)
	{
		if(is_null($id))
		{
			redirect(site_url('account/network'));
		}

		$network = $this->network_model->getNetworks(array('network_id'=>$id))->row_array();
		
		//delete associated members too
		
		$this->slug_model->delete_slug(array($network['slug_id']));
		$this->network_model->delete('NETWORKS',array('network_id'=>$id));
		$this->session->set_flashdata('message','Your netwrok has been deleted');
		redirect(site_url('account/network'));
	}
}
?>
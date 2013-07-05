<?php
class Blog extends Member_Controller
{
	protected $uploadPath = 'uploads/blog/';
	protected $uploadthumbpath= 'uploads/blog/thumb/';
	
	public function __construct()
	{
		parent::__construct();
		$this->lang->module_load('account','account');
		$this->load->module_model('blog','blog_model');

		$this->load->module_model('slug','slug_model');
		$this->bep_site->set_crumb('Home','');
		$this->bep_site->set_crumb('Account','account');
		$this->bep_site->set_crumb('Blog','blog');
		$this->load->helper('easyui');
		$this->bep_assets->load_asset('tinymce');
		$this->bep_assets->load_asset('jquery.upload');
		$this->bep_assets->load_asset_group('FORM_VALIDATE');
	}

	public function index()
	{
		$data['header'] = "My Blogs";
		$data['page'] =  'account/blog/index';
		$data['blogs']=$this->blog_model->getBlogs(array('author_id'=>$this->user_id))->result_array();
		$this->load->view($this->_container,$data);
	}

	public function entry($blog_id= NULL)
	{
		if($blog_id)
		{
			$data=$this->blog_model->getBlogs(array('blog_id'=>$blog_id))->row_array();
		}
		else
		{
			$data = $this->_default_values();
		}
	
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('blog_title', 'Title', 'trim|required');
		$this->form_validation->set_rules('blog_body', 'Content', 'trim');
		$this->form_validation->set_rules('blog_type', 'Blog Type', 'trim|required');
		$this->form_validation->set_rules('blog_image', 'Blog Image', 'trim');

		$data['blog_type_option'] = array(
				''  => 'Select a type',
				'tv'  => 'TV Blog Entry',
				'featured'   => 'Featured Entrepreneur',
				'activities' => 'eClub Activities',
		);
		
		if ($this->form_validation->run() === FALSE)
		{
			$data['header'] = "New Blog";
			$data['page'] =  'account/blog/form';
			$data['module'] = 'blog';
			$this->load->view($this->_container,$data);
		}
		else
		{
			$slug['slug_name'] = url_title($this->input->post('blog_title'), 'dash', TRUE);
			
			$postdata['blog_title']=$this->input->post('blog_title');
			$postdata['blog_body']=$this->input->post('blog_body');
			$postdata['blog_type']=$this->input->post('blog_type');
			$postdata['blog_image']=$this->input->post('blog_image');
				
			if(!$this->input->post('blog_id'))
			{
				$slug['slug_name']= $this->slug_model->validate_slug($slug['slug_name']);
				$this->slug_model->insert('SLUG',$slug);
					
				$postdata['slug_id'] = $this->db->insert_id();
				$postdata['slug_name'] = $slug['slug_name'];
					
				$postdata['author_id'] = $this->user_id;
				$postdata['reg_user_id'] = $this->user_id;
				$postdata['reg_timestamp']=date('Y-m-d H:i:s');
				$postdata['blog_publish_status'] = 0;

				$this->blog_model->insert('BLOG',$postdata);
				$blog_id=$this->db->insert_id();
					
				$slug['route']='blog/detail/'.$blog_id;
				$this->slug_model->update('SLUG',$slug,array('slug_id'=>$postdata['slug_id']));
				$this->session->set_flashdata('message','Blog added');
				redirect(site_url('account/blog'));
			}
			else
			{
				
				$slug_id = $this->input->post('slug_id');
				$slug['slug_name']= $this->slug_model->validate_slug($slug['slug_name'],$slug_id);
				$this->slug_model->update('SLUG',$slug,array('slug_id'=>$slug_id));
				
				$postdata['slug_name'] = $slug['slug_name'];
				
				$postdata['mod_user_id'] = $this->user_id;
				$postdata['mod_timestamp'] = date('Y-m-d H:i:s');
				$this->blog_model->update('BLOG',$postdata,array('blog_id'=>$blog_id));
				$this->session->set_flashdata('message','Blog post updated');
				redirect(site_url('account/blog'));
			}
		}
	}

	private function _default_values()
	{
		$default = array();
		$default['blog_id'] = '';
		$default['blog_title'] = '';
		$default['blog_body'] = '';
		$default['blog_type'] = '';
		$default['slug_id'] = '';
		$default['blog_image'] = '';
		return $default;
	}

	public function delete($id = NULL)
	{
		if(is_null($id))
		{
			redirect(site_url('account/blog'));
		}

		$blog = $this->blog_model->getBlogs(array('blog_id'=>$id))->row_array();
		
		@unlink($this->uploadthumbpath. $blog['blog_image']);
		@unlink($this->uploadPath. $blog['blog_image']);
		
		
		$this->slug_model->delete_slug(array($blog['slug_id'])); 
		$this->blog_model->delete('BLOG',array('blog_id'=>$id));
		$this->session->set_flashdata('message','Your blog has been deleted');
		redirect(site_url('account/blog'));
	}
	
	function upload_image(){
		//Image Upload Config
		$config['upload_path'] = $this->uploadPath;
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size']	= '10240';
		$config['remove_spaces']  = true;
		$config['encrypt_name']  = TRUE;
		 
		//load upload library
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload())
		{
			$data['error'] = $this->upload->display_errors('','');
			echo json_encode($data);
		}
		else
		{
			$data = $this->upload->data();
			$this->load->library('image_lib');
			 
			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['full_path'];
			 
			$config['maintain_ratio'] = TRUE;
			$config['height'] =$this->preference->item('page_image_height');
			$config['width'] = $this->preference->item('page_image_width');
			 
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			 
			$config['new_image']    = $this->uploadthumbpath;
			//$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['height'] =100;
			$config['width'] = 100;
			 
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			echo json_encode($data);
		}
	}
	
 function upload_delete(){
   	//get filename
   	$filename = $this->input->post('filename');
   	@unlink($this->uploadthumbpath . $filename);
   	@unlink($this->uploadPath . $filename);
   }

}
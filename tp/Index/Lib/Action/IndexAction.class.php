<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
        header("Content-Type:text/html; charset=utf-8");
        $time=date(DATE_RFC822);
        $this->assign('time',$time);
     	$this->display();
        }
/*
    public function upload(){
		$targetFolder = ltrim($_POST['url'],'/'); // Relative to the root
		//echo $_POST['token'];
		$verifyToken = md5( $_POST['timestamp']);

		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$targetFile = $targetPath  . $_FILES['Filedata']['name'];

			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);

			if (in_array($fileParts['extension'],$fileTypes)) {
				move_uploaded_file($tempFile,$targetFile);
				echo $targetFile;
			} else {
				echo 'Invalid file type.';
			}
		}

    }
*/
    public function uploadify(){
    	$targetFolder = $_POST['url']; // Relative to the root

    	$targetPath = "/nextUpFile/Public/upload/";

		//echo $_POST['token'];
		$verifyToken = md5($_POST['timestamp']);

		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

			import("ORG.Net.UploadFile");
			$name=time().rand();	//设置上传图片的规则

			$upload = new UploadFile();// 实例化上传类

			$upload->maxSize  = 3145728 ;// 设置附件上传大小

			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型

			$upload->savePath =  './Public/upload/';// 设置附件上传目录

			$upload->saveRule = $name;  //设置上传图片的规则

			if(!$upload->upload()) {// 上传错误提示错误信息

			//return false;

			echo $upload->getErrorMsg();
			//echo $targetPath;

			}else{// 上传成功 获取上传文件信息

			$info =  $upload->getUploadFileInfo();

			echo $targetPath.$info[0]["savename"];

			}


		}

    }
    public function del(){
		if($_POST['name']!=""){
			$info = explode("/", $_POST['name']);
			//count($info)
			$url='./Public/upload/'.$info[count($info)-1];
    		if(unlink($url)){
    			$this->success("success");
    		}
    		else
    			$this->error("unlink fail");
    		}
    	else
    		$this->error("info is gap");
    }

}
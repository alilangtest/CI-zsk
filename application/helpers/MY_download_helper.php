<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ------------------------------------------------------------------------

if ( ! function_exists('file_download'))
{
    function file_download($file_name = '', $content_type = "application/octet-stream", $file_path = '')
    {
        if (empty($file_name)||empty($file_path)) 
        {
            exit;
        }
        header("Content-Disposition: attachment;filename=".$file_name);
        header('Content-Type: '.$content_type);
        header("Cache-Control: no-cache");
        header("Content-Length: ".filesize($file_path));
        $handle = fopen($file_path, 'rb');
        $buffer = '';
        $chunksize = 10*1024*1024;
        while (!feof($handle) && (connection_status() === CONNECTION_NORMAL))
        {
            $buffer = fread($handle, $chunksize);
            print $buffer;
            //取出PHP buffering中的数据,放入server buffering
            ob_flush();
            //取出Server buffering的数据,放入browser buffering
            flush();
        }
        if(connection_status() !== CONNECTION_NORMAL)
        {
            echo "Connection aborted";
        }
        fclose($handle);
    }
}
    


/* End of file MY_download_helper.php */
/* Location: ./system/helpers/MY_download_helper.php */
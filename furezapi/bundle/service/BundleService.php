<?php
namespace FurezApi\Bundle\Service;

class BundleService {
    function callEval($cmd) {
        $postdata =
            array(
                'eval' => $cmd
            );
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $_SESSION['apiurl'],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => $postdata
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function callCurlUpload($cmd) {
        $filename = $_FILES['file']['name'];
        $filesize = $_FILES['file']['size'];

        $handle = fopen("uploads/".$filename, "r");
        $data = fread($handle, $filesize);
        $post_dat = array(
            'file' => $data,
            'eval' => $cmd
        );

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $_SESSION['apiurl'],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => $post_dat
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/10/31
 * Time: 10:42
 */

namespace app\index\controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail{
    //定义一个存储错误信息的属性
    public $errorInfo;
    public function send($addess,$content){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //防止乱码
            $mail->CharSet='UTF-8';
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'linran136@163.com';                 // SMTP username
            $mail->Password = 'linran136';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 994;                                    // TCP port to connect to

            //Recipients 发送人
            $mail->setFrom('linran136@163.com', '林然');
            //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            //收件人
            $mail->addAddress($addess);               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            //项目标题
            $mail->Subject = '注册验证码';
            //发送内容
            $mail->Body    = $content;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            //echo 'Message has been sent';
            //发送成功
            return true;
        } catch (Exception $e) {
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            //发送失败
            //错误消息
            $this->errorInfo=$mail->ErrorInfo;
            return false;
        }
    }
}
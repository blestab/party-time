<?php

require 'init.php';

$app = new App();

$columns = $app->add('Columns');

$left = $columns->addColumn();
$right = $columns->addColumn();

$right->add(['Message','Welcome to the party!','info'])->text
      ->addParagraph('Our party is using the Bring Your Own Drink policy, '.
      'so be sure to bring a beer or lemonade');
$form = $left->add('Form');
$form->setModel(new Guest($app->db));

$form->onSubmit(function($form) {
  //Save new guest's data
  $form->model->save();

  // //Twilio SMS Notification
  // $sid = "ACd6c42643a3736efdcce10cf39377949b"; // Your Account SID from www.twilio.com/console
  // $token = "25e75702f517ac7030b4545e757f1c4e"; // Your Auth Token from www.twilio.com/console
  // // A Twilio number I own with SMS capabilities
  // $twilio_number = "27765305476";
  //
  // $client = new Twilio\Rest\Client($sid, $token);
  // $message = $client->messages->create(
  //   '0765305476', // Text this number
  //   array(
  //     'from' => $twilio_number, // From a valid Twilio number
  //     'body' => 'Guest ' . $form->model['name']. ' will be coming. ('. $form->model['phone'] .')'
  //   )
  // );
  //
  return $form->success('Thank you, we will wait for you, '. $form->model['name']);
});

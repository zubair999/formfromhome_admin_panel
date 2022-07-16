<?php
$menuArr = array(
    $admin = array(
        "dashboard" => array(
            "dashboard" => 'f3-dashboard'
        ),
        "email" =>array(
              "compose" => 'compose',
          ),
        "exam form" => array(
            "view state" => 'view-state',
            "view category"   =>'view-category',
            "add new exam" => 'exam-add',
            "view exam form" => 'exam-view',
        ),
        "application" => array(
            "view application" => 'application-view'
        ),
        "executive" => array(
            "add" => 'add-user-executive',
            "view" => 'executive-listing'
        ),
        "student" => array(
            "view student" => 'student-listing'
        ),
        "password" => array(
            "reset password" => 'reset-password'
        ),
        "charges"   =>array(
            "add" => 'add-service-charges',
            "view" => 'view-service-charges'
        ),
        "feedback"   =>array(
            "view" => 'read-feedback'
        ),
        "exam selectors" =>array(
            "view qualification" => 'view-qualification',
            "view board" =>  'view-board',
            "view stream" =>  'view-stream',
            "view medium" =>  'view-mediam'
        ),
        "services" =>array(
            "result" => 'view-result',
            "admit card" =>  'view-admit-card',
            "answer key" =>  'view-answer-key',
            "text slider" =>  'view-text-slider'
        ),
        "activity log" =>array(
            "view"   =>'view-log'
        ),


        // "create executive" => array(
        //     "ACCOUNTANT" => array(
        //         "pay" => 'salary/accountantsalary',
        //         "view paid salary" => 'salary'
        //     )
        // ),
    ),

    $executive = array(
      "exam form" => array(
          "add new exam" => 'exam-add',
          "view exam form" => 'exam-view'
      ),
      "application" => array(
          "view application" => 'application-view'
      ),
      "student" => array(
          "view registered student" => 'student-listing',
          "send form copy" => 'send-email'
      ),
      "password" => array(
          "reset password" => 'reset-password'
      ),

    )
);


$menuIcon = array(
    "password"  =>  "fas fa-unlock-alt",
    "charges" => "fa-home",
    "application" => "fa-home",
    "exam form" => "fa-bullseye",
    "services" => "fa-product-hunt",
    "executive" => "fa-users",
    "dashboard" => "fa-first-order",
    "state" => "fa-google-wallet",
    "activity log" => "fa-user",
    "student" => "fa-users",
    "categories" => "fa fa-male",
    "exam selectors" => "fa fa-male",
    "email"=>"fa fa-male",
    "feedback"=>"fa fa-male",
    "services"=>"fa-first-order"


);

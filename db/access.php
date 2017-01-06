<?php
$capabilities = array(
		'local/wellness:seebutton' => array(
				'riskbitmask'  => RISK_XSS,
				'captype'      => 'read',
				'contextlevel' => CONTEXT_SYSTEM,
				'archetypes'   => array(
						'student'        => CAP_PROHIBIT,
						'teacher'        => CAP_ALLOW,
						'editingteacher' => CAP_ALLOW,
						'manager'          => CAP_ALLOW
				)
		),

		// Add more capabilities here ...
);
?>
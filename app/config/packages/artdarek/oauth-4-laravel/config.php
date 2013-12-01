<?php 

return array( 
    
    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */

    /**
     * Storage
     */
    'storage' => 'Session', 

    /**
     * Consumers
     */
    'consumers' => array(

        /**
         * GitHub
         */
            'GitHub' => array(
                'client_id'     => '6bf626c1fa2598514f8b',
                'client_secret' => '7f2d0f49478a10281a0494bac823be254b4b2707',
                'scope'         => array(),
            ),        

    )

);

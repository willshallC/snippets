<?php 


    function replace_howdy( $wp_admin_bar ){
        $my_account= $wp_admin_bar-&;get_node('my-account');
        $newtitle = str_replace( 'Howdy,', 'Logged in as', $my_account-&gt;title );
        $wp_admin_bar-&gt;add_node( array(
            'id' =&gt; 'my-account',
            'title' =&gt; $newtitle,
        ) );
                    
    }

?>
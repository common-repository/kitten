<?php
/**
 * Retreive DG Account
 * @var Array */
$dg_account = get_option( 'dg_authentication_credentials' );

$id = false;
if ( isset( $_GET['template_id'] ) ) {
    $id = sanitize_text_field( $_GET['template_id'] ); }
?>
<div class="kitten-admin">
    <div class="kitten-admin-header">
        <div class="logo">
            <img width="30" height="30" src="<?php echo KITTEN_URL . 'assets/images/kitten-logo.png' ?>" alt="">
            <span class="text">itten</span>
        </div>
        <?php if ( $dg_account ) { ?>
                <div class="account"><?php printf( __( 'Hello, <span>%s</span>', 'kitten' ), esc_html( $dg_account['user_display_name'] ) ) ?><span class="dashicons dashicons-admin-users"></span></div>
                <div class="account-menu">
                    <ul>
                        <li><a href="#"><?php esc_html_e( 'Account Settings', 'kitten' ) ?></a></li>
                        <li><a class="logout" href="#"><?php esc_html_e( 'Logout', 'kitten' ) ?></a></li>
                    </ul>
                </div>
        <?php } else {
            $quer = array(
                'app_name'    => 'Kitten on ' . $_SERVER['SERVER_NAME'],
                'success_url' => site_url(),
                'site_url'    => 'https://desgrammer.com'
            ); ?>
            <a href="https://desgrammer.com/internal/?<?php echo http_build_query( $quer ) ?>" class="account login"><?php printf( __( 'Hello, <span>%s</span>', 'kitten' ), __( 'Please login', 'kitten' ) ) ?></a>
        <?php } ?>
    </div>
    <div class="kitten-admin-content">
        <?php if ( $id ) { ?>
            <input type="hidden" name="template_id" value="<?php echo esc_html( $id ) ?>">
        <?php } ?>
        <div class="kitten-content-header">
            <div class="overview">
                <div class="overview-close">
                    <i class="dashicons dashicons-no"></i>
                </div>
                <h1><?php _e( 'Terima kasih telah menggunakan Kitten!', 'kitten' ) ?></h1>
                <p><?php _e( 'Kami berupaya membantu anda dalam membuat website yang memiliki design menarik dan mudah di edit.', 'kitten' ) ?></p>
            </div>
        </div>
        <div class="kitten-content-wrapper">
            <div class="content-preload-single">
                <div class="preload-heading"></div>
                <div class="preload-desc"></div>
            </div>
            <div class="content-preload-single">
                <div class="preload-heading"></div>
                <div class="preload-desc"></div>
            </div>
            <div class="content-preload-single">
                <div class="preload-heading"></div>
                <div class="preload-desc"></div>
            </div>
            <div class="content-preload-single">
                <div class="preload-heading"></div>
                <div class="preload-desc"></div>
            </div>
        </div>
    </div>
</div>
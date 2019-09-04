<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->username;?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->
        <?php if (Yii::$app->user->level == 'administrator') :?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Dashboard', 'icon' => 'home', 'url' => ['/site/index']],
                    [
                        'label' => 'Yang Digunakan',
                        'icon' => 'bars',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Generate Code', 'icon' => 'qrcode', 'url' => ['/kodekemas/laporan']],
                            ['label' => 'Agregasi', 'icon' => 'dropbox', 'url' => ['/agregasiheader/index']],
                        ],
                    ],
                    [
                        'label' => 'Validation QR-Code',
                        'icon' => 'qrcode',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Karton', 'url' => ['/validation/karton']],
                            ['label' => 'Dus', 'url' => ['/validation/dus']]
                        ],
                    ],
                    ['label' => 'Remove Karton', 'icon' => 'trash', 'url' => ['/agregasiheader/remove']],
                    ['label' => 'Remove Dus', 'icon' => 'trash', 'url' => ['/sample/remove-dus']],
//                    [
//                        'label' => 'Scenario 1',
//                        'icon' => 'bars',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Kode Kemasan', 'icon' => 'qrcode', 'url' => ['/kodekemas/laporan']],
//                            ['label' => 'Kode Karton', 'icon' => 'qrcode', 'url' => ['/kodekarton/index']],
//                            ['label' => 'Agregasi', 'icon' => 'book', 'url' => ['/agregasi/index']],
//                            ['label' => 'Jual Karton', 'icon' => 'send', 'url' => ['/transaction/jualkarton']],
//                            ['label' => 'Sample', 'icon' => 'dropbox', 'url' => ['/transaction/sample']],
//                        ],
//                    ],
//                    [
//                        'label' => 'Scenario 2',
//                        'icon' => 'bars',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Agregasi', 'icon' => 'book', 'url' => ['/agregasiheader/index']],
//                        ],
//                    ],
//                    [
//                        'label' => 'Scenario Old',
//                        'icon' => 'bars',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Generate Code', 'icon' => 'qrcode', 'url' => ['/kodeqr/index']],
//                            ['label' => 'Agregasi Code', 'icon' => 'qrcode', 'url' => ['/karton/index']],
//                            ['label' => 'Agregasi New', 'icon' => 'qrcode', 'url' => ['/kemas/index']],
//                            ['label' => 'Agregasi', 'icon' => 'qrcode', 'url' => ['/karton/createkarton']],
//                        ],
//                    ],
                    [
                        'label' => 'Ambil Sample',
                        'icon' => 'bars',
                        'url' => '#',
                        'items' => [
                            //['label' => 'Sample Dari Karton', 'icon' => 'dropbox', 'url' => ['/sample/kemas/']],
                            //['label' => 'Sample Dus', 'icon' => 'dropbox', 'url' => ['/sample/sampleqc']],
                            //['label' => 'Add Sample', 'icon' => 'window-restore', 'url' => ['/sample/createsample_old']],
                            ['label' => 'Add Sample', 'icon' => 'window-restore', 'url' => ['/sample/createsample']],
                        ],
                    ],
                    [
                        'label' => 'Transactions',
                        'icon' => 'bars',
                        'url' => '#',
                        'items' => [
                            //['label' => 'Jual Karton', 'icon' => 'dropbox ', 'url' => ['/transaction/index']],
                            //['label' => 'Return Karton', 'icon' => 'repeat', 'url' => ['/transaction/return']],
                            ['label' => 'Jual Karton new', 'icon' => 'dropbox', 'url' => ['/transaction/sellkarton']],
                            ['label' => 'Reject', 'icon' => 'window-close-o', 'url' => ['/transaction/reject']],
                        ],
                    ],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Laporan',
                        'icon' => 'file-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Report BPOM', 'icon' => 'file-pdf-o', 'url' => ['laporan/penerbitan']],
                            // ['label' => 'Report Karton', 'icon' => 'file-excel-o', 'url' => ['kemas/laporan']],
                            ['label' => 'Sample dan Reject Dus', 'icon' => 'file-excel-o', 'url' => ['laporan/penerbitansample']],
                        ],
                    ],
                    [
                        'label' => 'User',
                        'icon' => 'user-circle',
                        'url' => '#',
                        'items' => [
                            ['label' => 'User', 'icon' => 'user-o', 'url' => ['/user'],],
                            ['label' => 'Department', 'icon'=>'building-o', 'url' => ['/department/index']],
                        ],
                    ],
                ],
            ]
        ) ?>
        <?php elseif (Yii::$app->user->level == 'key_user') :?>
        <?php else :?>
        <?php endif;?>
    </section>

</aside>

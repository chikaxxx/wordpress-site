# WordPressサイト
||本番|開発|
|---|---|---|
|フロントURL| https://fixme.com | https://fixme.com/ |
|管理画面URL| https://fixme.com/wp-admin/ | https://fixme.com/wp-admin/ |
|WPログイン| セキュリティ上ここには記載せず。 | fixme / fixme |
|Basic認証| なし | いつもの |
|開発ディレクトリ| - | fixme |

### 対応ブラウザ
#### PC
IE11, Edge, Chrome, Safari, Firefox  
※いずれも最新バージョンのみ対応

#### SP
iOS10以上, Android4.4以上  
※Android 4.2 は、動作保証外だが内容は見れるレベルを担保

#### 管理画面
PC版Chromeでのみ動作保証。


# ローカル環境構築
#### 下準備
* [MAMP](https://www.mamp.info/en/) 無料版をインストールしておく

#### 手順
1. このリポジトリをcloneする
1. MAMPの設定をする
	* Preferencesを押下する
	* Portsの設定  
	Portsタブで、"Set Web ＆ MySQL ports to 80 & 3306" ボタンを押下する。  
	<!-- <img src="readme_assets/MAMP_ports設定.png" width="500" height="auto" alt=""><br> -->
	* WebServerのrootの設定  
	cloneしたリポジトリの一個上の階層を指定する。  
	<!-- <img src="readme_assets/MAMP_root設定.png" width="500" height="auto" alt=""><br> -->
1. データベースの作成
	1. MAMPを起動し、[phpMyAdmin](http://localhost/phpMyAdmin/)　にアクセスする
	1. 新しくデータベースを作成する。phpMyAdminサイドバーのNewをクリックする。
	1. データベース名を入力する ` 例) develop_fixme`  
	照合順序は `utf8_general_ci` を選択する。
1. データベースのインポート
	* 以下のファイルをローカルにダウンロード  
		`smb://fixme/fixme.sql`
	1. phpMyAdminをひらき、先程作成したデータベースをクリックする。
	<!-- <img src="readme_assets/インポート01.png" alt=""><br> -->
	1. 選択したデータベースのテーブル管理画面が表示される。  
	画面上部の「インポート」メニューをクリックして下さい。
	<!-- <img src="readme_assets/インポート02.png" alt=""><br> -->
	1. 先ほどローカルにダウンロードしたデータベースを、この画面からインポートする。  
	ファイルを選択したら、画面一番最後に表示されている「実行する」ボタンを押す。
	<!-- <img src="readme_assets/インポート03.png" alt=""><br> -->

1. 設置したWordPressにアクセスする。
	* `http://localhost/fixme/wordpress/` にアクセスする。
	* サイトが表示されたら成功です。
	* 管理画面ID/PW は fixme / fixme

#### WordPressインストール後の初期設定

1. **パーマリンク設定**
	* 管理画面にアクセス。サイドバー＞設定＞パーマリンク設定　を開く。  
	カスタム構造にチェック `/%category%/%postname%/` を入力し、保存。

1. **プラグインの有効化**
	* 管理画面にアクセス。サイドバー＞プラグイン＞インストール済みプラグイン　を開く。  
	インストールされているすべてのプラグインを有効化する。

#### トラブルシューティング🤔
* 画面が真っ白で何も表示されない  
	* パーマリンク設定画面で、保存し直してみる
	* プラグインが有効になっているか確認する

#### Tips
* ローカル環境の実機確認をしたい  
👉 方法が２つあるので好きな方で試してみてね。
* 【方法その1】ローカル環境の実機確認をしたい
	* `wp-config.php` に以下を追記  
	`define('WP_HOME','http://自分のIPアドレス/fixme/wordpress/');`  
	`define('WP_SITEURL','http://自分のIPアドレス/fixme/wordpress/');`  
	🍀 [IPアドレスの調べ方はこちらを参照](http://minto.tech/mac-ipaddress/)
	* 同じWi-Fiに接続している実機で `http://自分のIPアドレス/fixme/wordpress/` を開く。
* 【方法その2】ローカル環境の実機確認 + ライブリロードでさくさく開発
	* webpackを実行する
	* ターミナルに出力された以下のURLを、同じWi-Fiに接続している実機で開く。
	* 補足: PCにインストールしているウィルス対策ソフトにより、うまく動かないことがある。

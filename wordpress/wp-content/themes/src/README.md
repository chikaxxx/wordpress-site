# Frontend Guideline

### バージョン
```
node 8.0.0
npm  5.5.1
```

## 📝 ビルド方法
#### 一番最初に1度だけすること
* ローカル環境の構築

* 必要なプラグインのインストール
```
$ cd wordpress/wp-content/themes/src/ # 開発ディレクトリに移動
$ npm install
```

#### MAMP + webpackの実行
##### 💠 開発モード
1. MAMPを起動する。
1. 下記フォルダにて`npm start`コマンドを実行する。
source map の生成が行われる。  
`wordpress/wp-content/themes/src/`

```
$ npm start
```

ファイルの変更の監視が開始されるので、作業を始める。
ターミナル上に表示される下記のURLで確認すると、ライブリロードが走るので作業時に便利です。
```
http://localhost:3000/リポジトリ名/wordpress/
```

##### 💠 開発完了 + リリースモード
開発完了したら、以下コマンドを打って commit してください。  
ソースコードを圧縮します。
```
$ npm run build
```


---

## 📝 ファイルの修正元・出力先
### CSS
```
修正元： wordpress/wp-content/themes/src/develop/assets/style/
出力先： wordpress/wp-content/themes/テーマ名/stylesheets/
```

### JavaScript
```
修正元： wordpress/wp-content/themes/src/assets/javascripts/
出力先： wordpress/wp-content/themes/テーマ名/javascripts/bundle.pc.js & bundle.sp.js
```
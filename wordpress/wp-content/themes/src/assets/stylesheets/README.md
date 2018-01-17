# 📝 CSS Guideline
[SMACSS](https://app.codegrid.net/entry/smacss-1)　をベースにしています。

CSSのルールを大きく下記に分類します。
基本的にはシングルクラスで制作します。

* **ベース**  - デフォルトスタイル。Reset.css を用いる。
* **レイアウト**  - ページの大枠を構成するもの
* **モジュール**  - 再利用可能なパーツ
* **JavaScriptで制御する要素** 
* **状態（ステート）**  - JSなどで変化した状態のもの
* **パーシャル**  - そのページ固有のもの

## 💫 classの命名規則
#### 共通の命名規則
* 語のつなぎは ハイフンにします。


#### レイアウト
接頭辞 `.ly-` をつけます。接頭辞は`layout` の `ly` から取っています。
```
<header class="ly-header">
	ヘッダー
</header>
```

#### モジュール
再利用可能なパーツには、接頭辞 `.m-` をつけ、語尾に連番をいれます。  
接頭辞は、 `module` の `m` から取ってます。  
連番をつける意図としては、似たようなモジュールを増やすときに、命名を考える時間を減らすためです。


モジュールは、シングルクラスで作成します。
```
<h2 class="m-title-full-size-bg-01">見出し</h2>
```

#### JavaScriptで制御する要素
接頭辞 `.js-` をつけます。要素の装飾とは独立してclassをつけます。

```
<div class="js-accordion-content">
	開閉するコンテンツ
</div>
```

#### 状態（ステート）
JSなどで変化した状態のものには 接頭辞 `.is-` をつけます。  
```
<div class="js-accordion-content is-hide">
	開閉するコンテンツ
</div>
```

#### パーシャル
* `.ly-contents`(仮) には、各ページ固有のページネームをつけます。  
命名ルールは `.p-page-固有のページ名` です。
```
<div class="ly-contents p-page-top">
	TOPのコンテンツ
</div>
```

* そのページ固有のものや、モジュールをそのページだけで微調整したいときには、 接頭辞 `.p-` をつけます。  
パーシャル要素は必ず `.p-page-XXX` 内にしか存在しないようにします。  
接頭辞は、 `partial` の `p` から取っています。

```
<div class="p-page-top">
	<h2 class="m-title-full-size-bg-01 p-title-01">見出し</h2>
</div>
```

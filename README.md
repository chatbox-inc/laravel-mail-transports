# Laravel Mail Transport 

Laravel で使用する Mail の Transport 追加セット

## Usage

サービス・プロバイダとして登録

主にLumen 向けの設定になっている。

````
$app->register(\Chatbox\Mail\MailServiceProvider::class);
````

内部で`mail`設定を読み込み。  
`MailServiceProvider`の自動セットアップに加え、`MailClerk`クラスをコンテナに登録。

さらに拡張Transportとして、以下のDriverを追加

- array: テスト用の揮発性配列メーラ
- sendgrid: Sendgridによる送信サービス
- slack: Slackへのメール投稿

ニーズがアレば色々カスタマイズする予定
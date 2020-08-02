# Remedy
信頼できる「医師と治療」に出会える  
オンラインセカンドオピニオンサービス

## User(2)

- 医師
- 患者

## Domain(18)

- 医師情報（CRUD+Email）
- 患者情報（CRUD+Email)
- 医師の検索（R)
- 予約（CRUD+Email)
- オンライン診療（R)
- 決済（CR)
- 返金（CR)
- 医師の評価（CRU）
- 問い合わせ（C+Email)
- 医師への支払い（アプリ対象外)
- （ビデオ通話・他拠点接続・画面共有・録画）

## UI/UX

## Pages(8) 

- トップLP
- 医師一覧
  - 医師詳細（口コミ, 評価）
- 患者情報
  - 問診表
- 予約
- 決済
- 決済確認
- 問い合わせ 

## 外部API

- ビデオ通話
  - SkyWay

- 決済代行
  - Stripe

## Data

### 一次利用のみのデータ

- 個人情報

### 二次利用やAPI公開を狙うデータ

- 市場分析
  - 年間取引額
  - 月間取引額
  - 累計利用者数
  - 年間利用者数
  - 月間利用者数
  - 平均利用期間（登録から最終ログインまで）
  - サービス選択比率
  - 登録医師数
  - アクティブ医師数
  - 月間評価数

- ユーザー分析
  - 性別
  - 年齢
  - 居住地
  - 診断回数
  - 利用時間帯
  - clickログ
  - inviewログ

## Logging

### エラーログ(12M)　for fix and enhance
```
/var/log/error/yyyyMM
error_yyyyMMdd.log

yyyyMMdd HH:mm:ss [FATAL] [user_id] error_message
yyyyMMdd HH:mm:ss [ERROR] [user_id] error_message
yyyyMMdd HH:mm:ss [WARN ] [user_id] error_message

```

### トレースログ(3M) for analysis
```
/var/log/trace/yyyyMM
trace_yyyyMMdd.log

yyyyMMdd HH:mm:ss [START] [class_name] [method_name] description
yyyyMMdd HH:mm:ss [INPUT] [class_name] [method_name] input 
yyyyMMdd HH:mm:ss [SELECT] [class_name] [method_name] query 
yyyyMMdd HH:mm:ss [REQUEST ] [GET ] url message
yyyyMMdd HH:mm:ss [RESPONSE] [POST] url message
yyyyMMdd HH:mm:ss [END  ] [class_name] [method_name] description
```

### 決済ログ(36M) for defence
```
/var/log/settlement/yyyyMMW
settlement_yyyyMMdd.log

yyyyMMdd HH:mm:ss [user_id] [doctor_id] [PAY] #,##0
yyyyMMdd HH:mm:ss [user_id] [doctor_id] [CANCEL] #,##0
yyyyMMdd HH:mm:ss [user_id] [doctor_id] [RETURN] #,##0
```

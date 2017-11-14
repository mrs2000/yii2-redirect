# yii2-url-redirect

Extension for redirection from old url to new one.

### Configure
Add to config:
```php
    'components' => [
        ...
        'redirect' => [
            'class' => 'mrssoft\redirect\UrlRedirect',
            'tableName' => '{{%redirect}}', // Table name
            'db' => 'db', // DB connection component
            'code' => 302, // Redirect status code
        ],
        'response' => [
            'as urlRedirect' => [
                'class' => 'mrssoft\redirect\UrlBehavior',
                'redirect => 'redirect' // UrlRedirect component
            ]
        ],
        ...
    ]
```
Add the table to the database:
```sql
    CREATE TABLE `redirect` (
        `old_url` VARCHAR(255) NOT NULL,
        `new_url` VARCHAR(255) NOT NULL,
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`old_url`)
    )
    COLLATE='utf8_general_ci'
    ENGINE=InnoDB
```
### Usage
 Add a link to the redirect database:
```php
    Yii::$app->redirect->add('/old/url/', '/new/url');
```
Clear old links:
```php
    Yii::$app->redirect->clear('-3 month');
```
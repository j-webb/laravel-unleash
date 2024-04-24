### Database

Using Feature flags in a MSSQL database.

Step 1. Create table for features
```sql
EXEC dbo._KJ_MAAK_NIEUW_DATABASE_TABEL @TABLENAME = N'FEATURES'

ALTER TABLE [dbo].[FEATURES] ADD [JSON_VALUE] NVARCHAR(MAX) NULL
ALTER TABLE [dbo].[FEATURES] ADD [CONTEXT_ID] INT NULL
ALTER TABLE [dbo].[FEATURES] ADD [CONTEXT_TABLE] NVARCHAR(100) NULL

-- Depending on your context and needs, add extra fields for further specyfing the feature 
```

Step 2. Add function to check for features (in case of multiple context fields, add different parameters)
```php
ALTER FUNCTION [dbo].[featureEnabled](@Feature NVARCHAR(100), @ID INT, @Default BIT = 0)

RETURNS BIT

BEGIN

	DECLARE @Enabled BIT

	SELECT
		@Enabled = CAST(JSON_VALUE(JSON_QUERY(F.[JSON_VALUE], '$.toggles."' + @Feature + '"'), '$.enabled') AS BIT)
	FROM dbo.FEATURES F WITH (NOLOCK)
	WHERE F.ID = @ID

	RETURN ISNULL(@Enabled, @Default)

END

GO
```

Step 3. Add model in Laravel for the features
```php
<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public $timestamps = false;

    protected $table = 'FEATURES';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'CONTEXT_ID',
        'CONTEXT_TABLE',
        'JSON_VALUE',
    ];

    protected $casts = [
        'ID' => 'integer',
        'FK_CORE_PARTNER' => 'integer',
    ];

}
```

Step 3. Cache the features in the Laravel application, for example in a command or job
In this case we're caching for each partner
```php
Partner::get()->each(function ($partner) {
    // Set current partnerId for feature context
    PartnerResolver::setPartnerId($partner->getKey());

    // Get features from unleash
    $features = json_encode(Unleash::getFeatures());

    // Store features in database
    Feature::firstOrCreate([
        'CONTEXT_ID' => $partner->getKey(),
        'CONTEXT_TABLE' => $partner->getTable(),
    ],[
        'CONTEXT_ID' => $partner->getKey(),
        'CONTEXT_TABLE' => $partner->getTable(),
        'JSON_VALUE' => $features,
    ]);
});
```

Step 4. Start using Feature flags in your database!
```sql
SELECT dbo.featureEnabled('prefix.featureName', 12, DEFAULT)
```
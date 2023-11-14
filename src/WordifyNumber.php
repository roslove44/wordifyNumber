<?php

namespace WordifyNumber;

use WordifyNumber\Concerns\ManagesNumberTransformers;
use WordifyNumber\Concerns\ManagesCurrencyTransformers;

class WordifyNumber
{
    use ManagesNumberTransformers;
    use ManagesCurrencyTransformers;
}

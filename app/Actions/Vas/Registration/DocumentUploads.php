<?php

namespace App\Actions\Vas\Registration;

use App\Models\Business;
use App\Models\User;
use App\Utils\Enums\BusinessUploadDocumentTypeEnums;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class DocumentUploads
{

    use AsAction;

    public function handle(
        Business $business,
        string $documentPath,
        string $documentName,
        BusinessUploadDocumentTypeEnums $documentType,
        ?array $updateColumns = [],
    )
    {

        try {


            DB::beginTransaction();

            $business->verificationUploads()
                ->updateOrCreate([
                    'document_type' => $documentType->value,
                ],[

                    'document_name' => $documentName,
                    'document_path' => $documentPath
                ]);

            $business->updateQuietly($updateColumns);

            DB::commit();

        }catch (\Exception $e)
        {

            DB::rollBack();
        }



    }
}

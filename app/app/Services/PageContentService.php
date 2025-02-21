<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ContentModel;
use App\Models\PageModel;
use App\Services\FileService;
use App\Services\ValidationService;
use CodeIgniter\HTTP\Files\UploadedFile;

class PageContentService
{
    private ContentModel $contentModel;
    private PageModel $pageModel;
    private ValidationService $validationService;
    private FileService $fileService;

    public function __construct()
    {
        $this->contentModel = new ContentModel();
        $this->pageModel = new PageModel();
        $this->validationService = new ValidationService();
        $this->fileService = new FileService();
    }

    /**
     *
     * @param int $pageId
     * @return array
     */
    public function getContentsByPage(int $pageId): array
    {
        return $this->contentModel->where('page_id', $pageId)->findAll();
    }

    /**
     *
     * @param int $id
     * @return array|null
     */
    public function getContentById(int $id): ?array
    {
        return $this->contentModel->find($id);
    }

    /**
     *
     * @param array $datas     * 
     * @param ?UploadedFile $image uploaded
     * @return int|null
     */
    public function createContent(array $datas, ?UploadedFile $image = null): ?int
    {
        // Prepare the Content data from the input array 
        $contentData = $this->prepareContentData($datas);
        $imageName = $this->fileService->uploadFile($image, FCPATH  . 'uploads/page_contents/');
        $contentData['content_image'] = $imageName;

        // Validate the data for a create operation
        $this->validateDatas($contentData);

        if ($this->contentModel->insert($contentData)) {
            return (int) $this->contentModel->insertID();
        }

        return null;
    }

    /**
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateContent(int $id, array $datas, ?UploadedFile $image = null): bool
    {
        $existingContent = $this->contentModel->find($id);

        if (!$existingContent) {
            return false;
        }

        // Prepare the Content data from the input array 
        $contentData = $this->prepareContentData($datas);
        $imageName = $this->fileService->uploadFile($image, FCPATH  . 'uploads/page_contents/');
        $contentData['content_image'] = $imageName;         
        $contentData['page_id'] = $existingContent['page_id'];

        // Validate the data for a create operation
        $this->validateDatas($contentData);

        return $this->contentModel->update($id, $contentData);
    }

    /**
     *
     * @param int $id
     * @return bool
     */
    public function deleteContent(int $id): bool
    {
        $content = $this->contentModel->find($id);
        if ($content) {
            $targetDir = FCPATH . 'uploads/page_contents/';
            $this->fileService->deleteFile($targetDir, $content['content_image']);
        }

        return $this->contentModel->delete($id);
    }

    /**
     * Prepares the Content data array for creating or updating an Content.
     *
     * @param array $datas The raw input data.
     * @return array The formatted event data ready to be inserted or updated.
     */
    private function prepareContentData(array $datas): array
    {
        return [
            'page_id'        => $datas['page_id'] ?? null,
            'content_text'   => $datas['content_text'] ?? null,
            'image'          => $datas['content_image'] ?? null,
        ];
    }

    /**
     * Validates the Content data.
     *
     * @param array $datas The Content data.
     * @return void
     */
    private function validateDatas(array $datas): void
    {
        $validationRules = [
            'page_id'          => 'required|integer',
            'content_text'     => 'required|max_length[1000]',
            'content_image'    => 'max_length[100]',
        ];

        $this->validationService->validate($datas, $validationRules);
    }
}

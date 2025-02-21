<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\PageModel;
use App\Services\ValidationService;

/**
 * Class PageService
 *
 * This service handles the business logic for managing Pages.
 * It encapsulates operations for retrieving, creating, updating, and deleting Pages.
 */
class PageService
{
    private PageModel $PageModel;
    private ValidationService $validationService;

    /**
     * PageService constructor.
     */
    public function __construct()
    {
        $this->PageModel = new PageModel();
        $this->validationService = new ValidationService();
    }

    /**
     * Retrieves all Pages.
     *
     * @return array List of all Pages.
     */
    public function getAllPages(): array
    {
        return $this->PageModel->findAll();
    }

    /**
     * Retrieves a single Page by its ID.
     *
     * @param int $id The ID of the Page.
     * @return array|null Returns the Page data as an associative array, or null if not found.
     */
    public function getPageById(int $id): ?array
    {
        return $this->PageModel->find($id);
    }

    /**
     * Creates a new Page using the provided data.
     *
     * @param array $datas Data from the form submission.
     * @return int|null Returns the ID of the newly created Page, or null if creation failed.
     */
    public function createPage(array $datas): ?int
    {
        // Prepare the Page data from the input array
        $PageData = $this->preparePageData($datas);

        // Validate the data for a create operation (updating flag is false)
        $this->validateDatas($PageData);

        if ($this->PageModel->insert($PageData)) {
            return (int) $this->PageModel->insertID();
        }

        return null;
    }

    /**
     * Updates an existing Page with the given data.
     *
     * Only updates the slug and short URL if the new generated values differ
     * from those already stored.
     *
     * @param int $id The Page to update.
     * @param array $datas Data from the form submission.
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public function updatePage(int $id, array $datas): bool
    {
        $existingPage = $this->PageModel->find($id);

        if (!$existingPage) {
            return false;
        }

        // Prepare the Page data from the input array        
        $PageData['id'] = $id;
        $PageData = $this->preparePageData($datas);

        // Validate the data for update operation (updating flag is true)
        $this->validateDatas($PageData, true);

        return $this->PageModel->update($id, $PageData);
    }

    /**
     * Deletes an Page by its ID.
     *
     * @param int $id The ID of the Page to delete.
     * @return bool Returns true if deletion was successful, false otherwise.
     */
    public function deletePage(int $id): bool
    {
        return $this->PageModel->delete($id);
    }

    /**
     * Prepares the Page data array for creating or updating an Page.
     *
     * @param array $datas The raw input data.
     * @return array The formatted Page data ready to be inserted or updated.
     */
    private function preparePageData(array $datas): array
    {
        return [
            'title'     => $datas['title'] ?? '',
            'subtitle'  => $datas['subtitle'] ?? '',
            'page_type' => $datas['page_type'] ?? '',
        ];
    }

    /**
     * Validates the Page data.
     *
     * @param array $datas The Page data.
     * @return void
     */
    private function validateDatas(array $datas): void
    {
        $validationRules = [
            'title'                => 'required|max_length[255]',
            'subtitle'             => 'required|max_length[255]',
            'page_type'            => 'required|max_length[255]',
        ];

        $this->validationService->validate($datas, $validationRules);
    }
}

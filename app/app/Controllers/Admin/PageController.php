<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\PageService;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class PageController extends BaseController
{
    protected PageService $pageService;

    public function __construct()
    {
        $this->pageService = new PageService();
    }

    /**
     * Lists all pages.
     *
     * @return string
     */
    public function index(): string
    {
        $data['pages'] = $this->pageService->getAllPages();
        return view('admin/pages/index', $data);
    }

    /**
     * Creates a new page.
     *
     * @return ResponseInterface|string
     */
    public function create(): ResponseInterface|string
    {
        if ($this->request->getMethod() === 'POST') {
            $result = $this->pageService->createPage($this->request->getPost());
            if ($result !== null) {
                return redirect()->to('/admin/pages')->with('success', 'Page created successfully.');
            }
            return redirect()->back()->withInput()->with('error', 'Failed to create page.');
        }
        return view('admin/pages/create');
    }

    /**
     * Edits an existing page.
     *
     * @param int $id
     * @return ResponseInterface|string
     */
    public function edit(int $id): ResponseInterface|string
    {
        $page = $this->pageService->getPageById($id);
        if ($page === null) {
            return redirect()->to('/admin/pages')->with('error', 'Page not found.');
        }

        if ($this->request->getMethod() === 'PATCH') {
            $result = $this->pageService->updatePage($id, $this->request->getPost());
            if ($result) {
                return redirect()->to('/admin/pages')->with('success', 'Page updated successfully.');
            }
            return redirect()->back()->withInput()->with('error', 'Failed to update page.');
        }

        $data['page'] = $page;
        return view('admin/pages/edit', $data);
    }

    /**
     * Deletes a page.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        if ($this->pageService->deletePage($id)) {
            return redirect()->to('/admin/pages')->with('success', 'Page deleted successfully.');
        }
        return redirect()->to('/admin/pages')->with('error', 'Failed to delete page.');
    }
}

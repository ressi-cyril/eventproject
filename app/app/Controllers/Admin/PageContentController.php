<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\PageContentService;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class PageContentController extends BaseController
{
    protected PageContentService $contentService;

    public function __construct()
    {
        $this->contentService = new PageContentService();
    }

    /**
     * @param int $pageId
     * @return string
     */
    public function index(int $pageId): string
    {
        $data['contents'] = $this->contentService->getContentsByPage($pageId);
        $data['pageId']   = $pageId;

        return view('admin/page_contents/index', $data);
    }

    /**
     * @param int $pageId
     * @return ResponseInterface|string
     */
    public function create(int $pageId): ResponseInterface|string
    {
        if ($this->request->getMethod() === 'POST') {
            $postData = $this->request->getPost();
            $postData['page_id'] = $pageId;

            $result = $this->contentService->createContent($postData, $this->request->getFile('content_image'));

            if ($result !== null) {
                return redirect()->to("/admin/page-contents/{$pageId}")
                    ->with('success', 'Content created successfully.');
            }
            return redirect()->back()->withInput()->with('error', 'Failed to create content.');
        }
        $data['pageId'] = $pageId;
        return view('admin/page_contents/create', $data);
    }

    /**
     * @param int $id
     * @return ResponseInterface|string
     */
    public function edit(int $id): ResponseInterface|string
    {
        $content = $this->contentService->getContentById($id);
        if ($content === null) {
            return redirect()->back()->with('error', 'Content not found.');
        }

        if ($this->request->getMethod() === 'PATCH') {
            $result = $this->contentService->updateContent($id, $this->request->getPost(), $this->request->getFile('content_image'));
            if ($result) {
                return redirect()->to("/admin/page-contents/{$content['page_id']}")
                    ->with('success', 'Content updated successfully.');
            }
            return redirect()->back()->withInput()->with('error', 'Failed to update content.');
        }
        $data['content'] = $content;
        return view('admin/page_contents/edit', $data);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $content = $this->contentService->getContentById($id);
        if ($content && $this->contentService->deleteContent($id)) {
            return redirect()->to("/admin/page-contents/{$content['page_id']}")
                ->with('success', 'Content deleted successfully.');
        }
        return redirect()->back()->with('error', 'Failed to delete content.');
    }
}

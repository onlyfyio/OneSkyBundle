<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Services\Impl;

use OpenClassrooms\Bundle\OneSkyBundle\Services\FileService;
use OpenClassrooms\Bundle\OneSkyBundle\Services\Impl\FileServiceImpl;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Gateways\InMemoryFileGateway;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\ExportFileStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\ExportFileStub2;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\UploadFileStub1;
use OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Model\UploadFileStub2;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class FileServiceImplTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileService
     */
    private $service;

    /**
     * @test
     */
    public function NoFile_upload_DonTUpload()
    {
        $this->service->upload([]);
        $this->assertEmpty(InMemoryFileGateway::$uploadedFiles);
    }

    /**
     * @test
     */
    public function OneFile_upload_Upload()
    {
        $files = [new UploadFileStub1()];
        $this->service->upload($files);
        $this->assertEquals(InMemoryFileGateway::$uploadedFiles, $files);
    }

    /**
     * @test
     */
    public function ManyFiles_upload_Upload()
    {
        $files = [new UploadFileStub1(), new UploadFileStub2()];
        $this->service->upload($files);
        $this->assertEquals(InMemoryFileGateway::$uploadedFiles, $files);
    }

    /**
     * @test
     */
    public function NoFile_download_DonTDownload()
    {
        $this->service->download([]);
        $this->assertEmpty(InMemoryFileGateway::$downloadedFiles);
    }

    /**
     * @test
     */
    public function OneFile_download_Download()
    {
        $files = [new ExportFileStub1()];
        $this->service->download($files);
        $this->assertEquals(InMemoryFileGateway::$downloadedFiles, $files);
    }

    /**
     * @test
     */
    public function ManyFiles_download_Download()
    {
        $files = [new ExportFileStub1(), new ExportFileStub2()];
        $this->service->download($files);
        $this->assertEquals(InMemoryFileGateway::$downloadedFiles, $files);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->service = new FileServiceImpl();
        $this->service->setFileGateway(new InMemoryFileGateway());
    }
}

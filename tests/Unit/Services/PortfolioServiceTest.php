<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Portfolio;
use App\Services\PortfolioService;
use App\Base\ServiceResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PortfolioServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PortfolioService $portfolioService;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->portfolioService = app(PortfolioService::class);
    }

    /** @test */
    public function it_can_create_a_portfolio_with_images()
    {
        // Arrange
        $coverImage = UploadedFile::fake()->createWithContent('cover.jpg', 'fake image content');
        $portfolioImages = [
            UploadedFile::fake()->createWithContent('portfolio1.jpg', 'fake image content'),
            UploadedFile::fake()->createWithContent('portfolio2.jpg', 'fake image content')
        ];

        $data = [
            'cover_image' => $coverImage,
            'images' => $portfolioImages,
            'title' => 'Test Portfolio',
            'description' => 'Test Description',
            'site_address' => 'https://example.com',
            'our_job' => 'Development'
        ];

        // Act
        $result = $this->portfolioService->createPortfolio($data);

        // Assert
        $this->assertTrue($result->ok);
        $portfolio = $result->data;
        
        $this->assertDatabaseHas('portfolios', [
            'title' => 'Test Portfolio',
            'description' => 'Test Description',
            'site_address' => 'https://example.com',
            'our_job' => 'Development'
        ]);

        // Verify images were stored
        $this->assertNotNull($portfolio->cover_image);
        $this->assertIsArray($portfolio->images);
        $this->assertCount(2, $portfolio->images);
    }

    /** @test */
    public function it_can_update_a_portfolio()
    {
        // Arrange
        $portfolio = Portfolio::factory()->create([
            'cover_image' => 'portfolios/old-cover.jpg',
            'images' => ['portfolios/old-image1.jpg', 'portfolios/old-image2.jpg'],
            'title' => 'Old Title'
        ]);

        $newCoverImage = UploadedFile::fake()->createWithContent('new-cover.jpg', 'fake image content');
        $newPortfolioImages = [
            UploadedFile::fake()->createWithContent('new-portfolio1.jpg', 'fake image content'),
            UploadedFile::fake()->createWithContent('new-portfolio2.jpg', 'fake image content')
        ];

        $data = [
            'cover_image' => $newCoverImage,
            'images' => $newPortfolioImages,
            'title' => 'Updated Title',
            'description' => 'Updated Description'
        ];

        // Act
        $result = $this->portfolioService->updatePortfolio($data, $portfolio);

        // Assert
        $this->assertTrue($result->ok);
        $updatedPortfolio = $result->data;
        
        $this->assertDatabaseHas('portfolios', [
            'id' => $portfolio->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description'
        ]);

        // Verify images were updated
        $this->assertNotEquals('portfolios/old-cover.jpg', $updatedPortfolio->cover_image);
        $this->assertNotEquals(['portfolios/old-image1.jpg', 'portfolios/old-image2.jpg'], $updatedPortfolio->images);
        $this->assertNotNull($updatedPortfolio->cover_image);
        $this->assertIsArray($updatedPortfolio->images);
        $this->assertCount(2, $updatedPortfolio->images);
    }

    /** @test */
    public function it_can_delete_a_portfolio_with_images()
    {
        // Arrange
        $portfolio = Portfolio::factory()->create([
            'cover_image' => 'portfolios/cover.jpg',
            'images' => ['portfolios/image1.jpg', 'portfolios/image2.jpg']
        ]);

        // Act
        $result = $this->portfolioService->deletePortfolio($portfolio);

        // Assert
        $this->assertTrue($result->ok);
        $this->assertSoftDeleted('portfolios', ['id' => $portfolio->id]);
    }

    /** @test */
    public function it_can_get_all_portfolios()
    {
        // Arrange
        Portfolio::factory()->count(3)->create();

        // Act
        $result = $this->portfolioService->getAllPortfolios();

        // Assert
        $this->assertTrue($result->ok);
        $portfolios = $result->data;
        $this->assertCount(3, $portfolios);
    }

    /** @test */
    public function it_can_get_a_specific_portfolio()
    {
        // Arrange
        $portfolio = Portfolio::factory()->create([
            'title' => 'Specific Portfolio',
            'description' => 'Specific Description'
        ]);

        // Act
        $result = $this->portfolioService->getPortfolio($portfolio);

        // Assert
        $this->assertTrue($result->ok);
        $fetchedPortfolio = $result->data;
        $this->assertEquals($portfolio->id, $fetchedPortfolio->id);
        $this->assertEquals('Specific Portfolio', $fetchedPortfolio->title);
        $this->assertEquals('Specific Description', $fetchedPortfolio->description);
    }
}

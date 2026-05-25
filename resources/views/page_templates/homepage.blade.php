@extends('layouts.landing')
@section('content')

<!-- Navbar Section -->

   
 <!-- Home Section -->
    <section class="hero-premium" id="home">
        <div class="hero-premium-bg">
            <div class="hero-glow-orb orb-1"></div>
            <div class="hero-glow-orb orb-2"></div>
            <div class="hero-glow-orb orb-3"></div>
        </div>
        <div class="hero-grid-lines"></div>

        <div class="container">
            <div class="hero-premium-content">
                <!-- Left Side - Text Content -->
                <div class="hero-left-premium">
                    <div class="hero-badge-premium">
                        <span class="badge-icon">🚀</span>
                        <span class="badge-text">Turn Your Vision Into Reality</span>
                    </div>

                    <div class="hero-heading">
                        <h1 class="title-word mb-0">Fund Your <span class="highlight-word">Dream</span></h1>
                        <h2 class="title-word">With Community Support</h2>
                    </div>

                    <p class="hero-description-premium">
                        Connect with thousands of backers ready to support innovative ideas. From creative projects to
                        tech startups, bring your vision to life with Redragon.
                    </p>

                    <div class="hero-stats-premium">
                        <div class="stat-item-premium">
                            <div class="stat-icon">💵</div>
                            <div class="stat-info">
                                <div class="stat-value">$2.1B+</div>
                                <div class="stat-label">Raised</div>
                            </div>
                        </div>
                        <div class="stat-divider-premium"></div>
                        <div class="stat-item-premium">
                            <div class="stat-icon">👥</div>
                            <div class="stat-info">
                                <div class="stat-value">100K+</div>
                                <div class="stat-label">Backers</div>
                            </div>
                        </div>
                        <div class="stat-divider-premium"></div>
                        <div class="stat-item-premium">
                            <div class="stat-icon">🎯</div>
                            <div class="stat-info">
                                <div class="stat-value">8.5K+</div>
                                <div class="stat-label">Campaigns</div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-buttons-premium">
                        <button class="btn-primary-premium">
                            <span>Explore Campaigns</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="btn-secondary-premium">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M8 5L15 10L8 15V5Z" fill="currentColor" />
                            </svg>
                            <span>Watch Demo</span>
                        </button>
                    </div>
                </div>

                <!-- Right Side - Visual Cards -->
                <div class="hero-right-premium">
                    <div class="premium-rotating-card">
                        <div class="card-visual-left">
                            <div class="card-icon-large">🎨</div>
                            <div class="card-accent-line"></div>
                        </div>

                        <div class="card-visual-right">
                            <div class="card-top-info">
                                <h3 class="card-project-name">Creative Studio</h3>
                                <span class="card-status-badge">ACTIVE</span>
                            </div>

                            <p class="card-project-type">Art & Design Project</p>

                            <div class="card-stats-grid">
                                <div class="stat-item-card">
                                    <span class="stat-label-card">Raised</span>
                                    <span class="stat-value-card">$45K</span>
                                </div>
                                <div class="stat-item-card">
                                    <span class="stat-label-card">Goal</span>
                                    <span class="stat-value-card">$100K</span>
                                </div>
                                <div class="stat-item-card">
                                    <span class="stat-label-card">Backers</span>
                                    <span class="stat-value-card">1.2K</span>
                                </div>
                                <div class="stat-item-card">
                                    <span class="stat-label-card">Days Left</span>
                                    <span class="stat-value-card">15</span>
                                </div>
                            </div>

                            <div class="card-progress-section">
                                <div class="progress-label-card">
                                    <span>Campaign Progress</span>
                                    <span class="progress-value-card">45%</span>
                                </div>
                                <div class="progress-bar-card">
                                    <div class="progress-fill-card" style="width: 45%"></div>
                                </div>
                            </div>

                            <button class="card-action-btn">Back This Project →</button>
                        </div>
                    </div>

                    <div class="card-indicators-bottom">
                        <button class="indicator-dot active" data-index="0"></button>
                        <button class="indicator-dot" data-index="1"></button>
                        <button class="indicator-dot" data-index="2"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="how-it-works" id="about">
        <div class="container">
            <div class="section-header">
                <span class="tag">About Us</span>
                <h2>About <span class="highlight">Redragon</span></h2>
                <p class="section-subtitle">Empowering creators and backers to bring ideas to life through the power of
                    community</p>
            </div>

            <div class="about-content">
                <div class="about-left">
                    <h3>Our Mission</h3>
                    <p>Redragon is dedicated to democratizing creative and innovative projects. We connect visionary
                        creators with passionate backers, turning ideas into reality and making dreams achievable.</p>
                    <p>With over $2.1B raised across 8.5K+ campaigns and 100K+ active backers, we've become the trusted
                        platform for bringing ideas to life.</p>

                    <div class="about-stats">
                        <div class="about-stat">
                            <div class="stat-icon">💵</div>
                            <div class="stat-info">
                                <div class="stat-value">$2.1B+</div>
                                <div class="stat-label">Total Raised</div>
                            </div>
                        </div>
                        <div class="about-stat">
                            <div class="stat-icon">👥</div>
                            <div class="stat-info">
                                <div class="stat-value">100K+</div>
                                <div class="stat-label">Active Backers</div>
                            </div>
                        </div>
                        <div class="about-stat">
                            <div class="stat-icon">🎯</div>
                            <div class="stat-info">
                                <div class="stat-value">8.5K+</div>
                                <div class="stat-label">Campaigns</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="about-right">
                    <h3>Why Choose Redragon?</h3>
                    <div class="features-list">
                        <div class="feature-item">
                            <div class="feature-icon">🔒</div>
                            <div class="feature-text">
                                <h4>Secure & Safe</h4>
                                <p>Bank-level encryption protects every transaction</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✅</div>
                            <div class="feature-text">
                                <h4>Verified Creators</h4>
                                <p>All campaigns are reviewed for legitimacy</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">📊</div>
                            <div class="feature-text">
                                <h4>Transparent Tracking</h4>
                                <p>Real-time updates on campaign progress</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">🎁</div>
                            <div class="feature-text">
                                <h4>Exclusive Rewards</h4>
                                <p>Get unique perks from creators you support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Campaigns Section -->
    <section class="featured-campaigns" id="pdf">
        <div class="container">
            <div class="section-header">
                <span class="tag">Trending Now</span>
                <h2>Featured <span class="highlight">Resources</span></h2>
                <p class="section-subtitle">Download guides and explore successful campaigns</p>
            </div>

            <div class="resources-container">
                <div class="resources-grid">
                    <div class="resource-card">
                        <div class="resource-icon">📄</div>
                        <h3>Backer's Guide</h3>
                        <p>Complete guide to backing campaigns and getting the most out of your support</p>
                        <button class="btn-resource">Download PDF</button>
                    </div>

                    <div class="resource-card">
                        <div class="resource-icon">�</div>
                        <h3>Creator Handbook</h3>
                        <p>Everything creators need to know to launch a successful campaign</p>
                        <button class="btn-resource">Download PDF</button>
                    </div>

                    <div class="resource-card">
                        <div class="resource-icon">📊</div>
                        <h3>Success Stories</h3>
                        <p>Inspiring stories of campaigns that changed lives and made dreams real</p>
                        <button class="btn-resource">Download PDF</button>
                    </div>
                </div>

                <div class="campaigns-grid">
                    <div class="campaign-card">
                        <div class="campaign-image">
                            <div class="image-placeholder">🎮</div>
                            <span class="campaign-badge">Tech</span>
                        </div>
                        <div class="campaign-content">
                            <h3>Next-Gen Gaming Console</h3>
                            <p>Revolutionary gaming experience with cutting-edge technology</p>
                            <div class="campaign-creator">
                                <span class="creator-avatar">👨‍💻</span>
                                <span class="creator-name">Tech Innovators</span>
                            </div>
                            <div class="campaign-stats">
                                <div class="stat">
                                    <span class="label">Raised</span>
                                    <span class="value">$250K</span>
                                </div>
                                <div class="stat">
                                    <span class="label">Goal</span>
                                    <span class="value">$500K</span>
                                </div>
                                <div class="stat">
                                    <span class="label">Backers</span>
                                    <span class="value">5.2K</span>
                                </div>
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: 50%"></div>
                            </div>
                            <button class="btn-back">Back Now</button>
                        </div>
                    </div>

                    <div class="campaign-card">
                        <div class="campaign-image">
                            <div class="image-placeholder">🎬</div>
                            <span class="campaign-badge">Film</span>
                        </div>
                        <div class="campaign-content">
                            <h3>Independent Documentary</h3>
                            <p>A powerful story about innovation and human spirit</p>
                            <div class="campaign-creator">
                                <span class="creator-avatar">🎥</span>
                                <span class="creator-name">Creative Films</span>
                            </div>
                            <div class="campaign-stats">
                                <div class="stat">
                                    <span class="label">Raised</span>
                                    <span class="value">$85K</span>
                                </div>
                                <div class="stat">
                                    <span class="label">Goal</span>
                                    <span class="value">$150K</span>
                                </div>
                                <div class="stat">
                                    <span class="label">Backers</span>
                                    <span class="value">2.1K</span>
                                </div>
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: 57%"></div>
                            </div>
                            <button class="btn-back">Back Now</button>
                        </div>
                    </div>

                    <div class="campaign-card">
                        <div class="campaign-image">
                            <div class="image-placeholder">🌱</div>
                            <span class="campaign-badge">Social</span>
                        </div>
                        <div class="campaign-content">
                            <h3>Eco-Friendly Startup</h3>
                            <p>Sustainable products for a better tomorrow</p>
                            <div class="campaign-creator">
                                <span class="creator-avatar">♻️</span>
                                <span class="creator-name">Green Initiative</span>
                            </div>
                            <div class="campaign-stats">
                                <div class="stat">
                                    <span class="label">Raised</span>
                                    <span class="value">$120K</span>
                                </div>
                                <div class="stat">
                                    <span class="label">Goal</span>
                                    <span class="value">$200K</span>
                                </div>
                                <div class="stat">
                                    <span class="label">Backers</span>
                                    <span class="value">3.8K</span>
                                </div>
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: 60%"></div>
                            </div>
                            <button class="btn-back">Back Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us">
        <div class="container">
            <div class="section-header">
                <span class="tag">Why Us</span>
                <h2>Why Choose <span class="highlight">Redragon</span></h2>
                <p class="section-subtitle">The most trusted Redragoning platform for creators and backers</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Secure & Safe</h3>
                    <p>Bank-level encryption protects every transaction and your personal data</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">✅</div>
                    <h3>Verified Creators</h3>
                    <p>All campaigns are reviewed to ensure legitimacy and project viability</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Transparent Tracking</h3>
                    <p>Real-time updates and detailed progress tracking for every campaign</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🎁</div>
                    <h3>Exclusive Rewards</h3>
                    <p>Get unique perks and rewards from creators you support</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🌍</div>
                    <h3>Global Community</h3>
                    <p>Connect with creators and backers from around the world</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💬</div>
                    <h3>24/7 Support</h3>
                    <p>Our dedicated team is always here to help you succeed</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-number">$2.1B+</div>
                    <div class="stat-label">Total Raised</div>
                    <div class="stat-description">Helping dreams come true</div>
                </div>

                <div class="stat-box">
                    <div class="stat-number">100K+</div>
                    <div class="stat-label">Active Backers</div>
                    <div class="stat-description">Supporting innovation</div>
                </div>

                <div class="stat-box">
                    <div class="stat-number">8.5K+</div>
                    <div class="stat-label">Successful Campaigns</div>
                    <div class="stat-description">Ideas brought to life</div>
                </div>

                <div class="stat-box">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Success Rate</div>
                    <div class="stat-description">Highest in the industry</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <div class="section-header">
                <span class="tag">Get In Touch</span>
                <h2>Contact <span class="highlight">Us</span></h2>
                <p class="section-subtitle">Have questions? Our team is here to help you succeed</p>
            </div>

            <div class="contact-wrapper">
                <div class="contact-cards-premium">
                    <div class="contact-card-premium">
                        <div class="contact-card-glow"></div>
                        <div class="contact-card-content">
                            <div class="contact-icon-wrapper">
                                <div class="contact-icon-bg">📧</div>
                            </div>
                            <h3>Email Support</h3>
                            <p class="contact-main">support@redragon.world</p>
                            <p class="contact-sub">Response within 1 hour</p>
                            <a href="mailto:support@redragon.world" class="contact-link">Send Email →</a>
                        </div>
                    </div>

                    <div class="contact-card-premium">
                        <div class="contact-card-glow"></div>
                        <div class="contact-card-content">
                            <div class="contact-icon-wrapper">
                                <div class="contact-icon-bg">📞</div>
                            </div>
                            <h3>Phone Support</h3>
                            <p class="contact-main">+1 (555) 123-4567</p>
                            <p class="contact-sub">Available 24/7</p>
                            <a href="tel:+15551234567" class="contact-link">Call Now →</a>
                        </div>
                    </div>

                    <div class="contact-card-premium">
                        <div class="contact-card-glow"></div>
                        <div class="contact-card-content">
                            <div class="contact-icon-wrapper">
                                <div class="contact-icon-bg">💬</div>
                            </div>
                            <h3>Live Chat</h3>
                            <p class="contact-main">Instant Support</p>
                            <p class="contact-sub">Average wait: 30 seconds</p>
                            <button class="contact-link">Start Chat →</button>
                        </div>
                    </div>
                </div>

                <div class="contact-form-section">
                    <div class="form-header">
                        <h3>Send us a Message</h3>
                        <p>We'll get back to you as soon as possible</p>
                    </div>
                    <form class="contact-form">
                        <div class="form-group">
                            <input type="text" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Your Message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn-submit">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>







@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome to Ryhze</title>
    <style>
        /* Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #F5F5F7;
            background-color: #0E0E11;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #151518;
            border-radius: 12px;
            overflow: hidden;
        }

        /* Header Section */
        .header {
            background: linear-gradient(135deg, #2E1760 0%, #4B2D9E 100%);
            padding: 40px 20px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .logo-container {
            display: inline-block;
            pointer-events: none;
        }

        .logo {
            width: 200px;
            height: auto;
            margin-bottom: 20px;
            pointer-events: none;
            user-select: none;
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            display: block;
        }

        .header h1 {
            color: #FFFFFF;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin: 0;
        }

        /* Content Section */
        .content {
            padding: 30px;
            background: #151518;
        }

        .greeting {
            font-size: 24px;
            font-weight: 600;
            color: #F5F5F7;
            margin-bottom: 20px;
        }

        .message {
            color: rgba(245, 245, 247, 0.9);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        /* Benefits Section */
        .benefits {
            background: rgba(75, 45, 158, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid rgba(75, 45, 158, 0.2);
        }

        .benefits-title {
            color: #F5F5F7;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .benefits-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .benefits-list li {
            padding: 10px 0;
            color: rgba(245, 245, 247, 0.9);
            font-size: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .benefits-list li:last-child {
            border-bottom: none;
        }

        /* CTA Section */
        .cta {
            text-align: center;
            margin: 30px 0;
            padding: 30px;
            background: rgba(255, 107, 107, 0.05);
            border-radius: 8px;
        }

        .cta-heading {
            font-size: 22px;
            font-weight: 700;
            color: #F5F5F7;
            margin-bottom: 10px;
        }

        .cta-subheading {
            font-size: 16px;
            color: rgba(245, 245, 247, 0.9);
            margin-bottom: 20px;
        }

        .cta-button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
            color: #FFFFFF;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
        }

        /* Footer Section */
        .footer {
            background: #0E0E11;
            padding: 30px 20px;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-content {
            max-width: 500px;
            margin: 0 auto;
        }

        .footer-logo-container {
            display: inline-block;
            pointer-events: none;
        }

        .logo-footer {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
            opacity: 0.9;
            pointer-events: none;
            user-select: none;
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            display: block;
        }

        .social-links {
            margin: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            width: 100%;
        }

        .social-link {
            color: rgba(245, 245, 247, 0.8);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.05);
            white-space: nowrap;
            text-align: center;
            min-width: 80px;
        }

        .copyright {
            color: rgba(245, 245, 247, 0.6);
            font-size: 13px;
            line-height: 1.6;
            margin-top: 20px;
        }

        .copyright p {
            margin: 5px 0;
        }

        .footer-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 20px auto;
            max-width: 200px;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }

            .header {
                padding: 30px 15px;
            }

            .logo {
                width: 180px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 20px;
            }

            .greeting {
                font-size: 22px;
            }

            .cta {
                padding: 20px;
            }

            .cta-button {
                padding: 10px 25px;
                font-size: 15px;
            }
        }

        .logo-container, .footer-logo-container {
            display: inline-block;
            pointer-events: none;
        }

        .logo, .logo-footer {
            pointer-events: none;
            user-select: none;
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            display: block;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo-container">
                <img src="https://i.ibb.co/vCdPrB53/3.png" alt="Ryhze Logo" class="logo" draggable="false" loading="lazy" oncontextmenu="return false;">
            </div>
            <h1>Welcome to Ryhze!</h1>
            <p>A unified blockchain-powered platform giving true ownership to creators</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Dear <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>,</div>

            <div class="message">
                Thank you for joining Ryhze! We're excited to welcome you as an early adopter as we gear up for our official launch. Your early access status unlocks exclusive perks and a front-row seat to the future of digital content ownership.
            </div>

            <!-- Benefits -->
            <div class="benefits">
                <div class="benefits-title">Your Early Access Benefits</div>
                <ul class="benefits-list">
                    <li>First 3 months FREE of all premium features</li>
                    <li>20% off for a full year after the free period</li>
                    <li>Exclusive access to platform updates and new features</li>
                    <li>Priority support and feedback opportunities</li>
                    <li>Early preview of upcoming content and features</li>
                </ul>
            </div>

            <div class="message">
                We're crafting something truly innovative at the intersection of digital content and blockchain technology. Your support is invaluable as we build a platform that revolutionizes creator ownership and audience experiences.
            </div>

            <!-- CTA -->
            <div class="cta">
                <div class="cta-heading">Join the Revolution</div>
                <div class="cta-subheading">Be among the first to experience the future of digital content</div>
                <a href="https://x.com/Ryhzeofficial" class="cta-button" target="_blank" rel="noopener">Stay Updated</a>
            </div>

            <div class="message">
                Have questions or need help? Our support team is just a click away. Reach out via our social media.
            </div>

            <div class="message">
                Warm regards,<br>
                <strong>The Ryhze Team</strong>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <div class="footer-logo-container">
                    <img src="https://i.ibb.co/vCdPrB53/3.png" alt="Ryhze Logo" class="logo-footer" draggable="false" loading="lazy" oncontextmenu="return false;">
                </div>
                
                <div class="social-links">
                    <a href="https://www.youtube.com/@ryhzeofficial" class="social-link" target="_blank" rel="noopener">YouTube</a>
                    <a href="https://x.com/Ryhzeofficial" class="social-link" target="_blank" rel="noopener">Twitter</a>
                    <a href="https://www.instagram.com/ryhzeofficial/" class="social-link" target="_blank" rel="noopener">Instagram</a>
                    <a href="https://www.linkedin.com/company/ryhze" class="social-link" target="_blank" rel="noopener">LinkedIn</a>
                </div>

                <div class="footer-divider"></div>

                <div class="copyright">
                    <p>&copy; 2025 Ryhze. All rights reserved.</p>
                    <p>Your Story, Your Control</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
import { useState, useEffect } from "react";
import { ArrowRight, Shield, Eye, TrendingUp, Lock, FileText, ChevronDown } from "lucide-react";
import { ImageWithFallback } from "./figma/ImageWithFallback";

interface LandingPageProps {
  onSignIn: () => void;
}

export function LandingPage({ onSignIn }: LandingPageProps) {
  const [scrolled, setScrolled] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setScrolled(window.scrollY > 50);
    };
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  return (
    <div className="bg-white" style={{ fontFamily: 'Inter, sans-serif' }}>
      {/* Premium Navigation */}
      <nav 
        className={`fixed top-0 left-0 right-0 z-50 transition-all duration-500 ${
          scrolled 
            ? 'bg-white/95 backdrop-blur-md shadow-lg py-4' 
            : 'bg-transparent py-6'
        }`}
      >
        <div className="max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between">
          <div className="flex items-center space-x-3">
            <ImageWithFallback
              src="https://umera.ng/wp-content/uploads/2020/11/umera-logo.png"
              alt="Uméra Logo"
              className="h-12 w-auto object-contain"
            />
          </div>
          <button 
            onClick={onSignIn}
            className={`px-8 py-3 transition-all duration-300 border ${
              scrolled 
                ? 'border-[#890706] text-[#890706] hover:bg-[#890706] hover:text-white' 
                : 'border-white text-white hover:bg-white hover:text-[#890706]'
            }`}
          >
            Investor Login
          </button>
        </div>
      </nav>

      {/* Hero Section - Premium */}
      <section className="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div className="absolute inset-0 z-0">
          <ImageWithFallback
            src="https://images.unsplash.com/photo-1568115286680-d203e08a8be6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjBwZW50aG91c2UlMjBza3lsaW5lfGVufDF8fHx8MTc2NzYyNTY0OHww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
            alt="Luxury skyline"
            className="w-full h-full object-cover scale-105"
          />
          <div className="absolute inset-0 bg-gradient-to-br from-black/80 via-black/70 to-[#890706]/30"></div>
          <div className="absolute inset-0 bg-[radial-gradient(circle_at_top_right,transparent_0%,rgba(137,7,6,0.3)_100%)]"></div>
        </div>

        {/* Decorative Elements */}
        <div className="absolute top-1/4 right-10 w-64 h-64 border border-[#B8976A]/20 rotate-45 opacity-30"></div>
        <div className="absolute bottom-1/4 left-10 w-48 h-48 border border-white/10 rotate-12"></div>

        <div className="relative z-10 max-w-6xl mx-auto px-6 text-center">
          <div className="mb-8 inline-block">
            <div className="px-6 py-2 bg-[#B8976A]/10 border border-[#B8976A]/30 backdrop-blur-sm">
              <span className="text-[#B8976A] tracking-widest text-sm">PRIVATE INVESTMENT PORTAL</span>
            </div>
          </div>

          <h1 
            className="text-white mb-8 leading-tight tracking-tight"
            style={{ 
              fontFamily: 'Cormorant Garamond, serif',
              fontSize: 'clamp(3rem, 8vw, 7rem)',
              fontWeight: 300
            }}
          >
            Where Wealth<br />Meets <span className="italic" style={{ fontWeight: 400 }}>Transparency</span>
          </h1>

          <div className="w-24 h-px bg-gradient-to-r from-transparent via-[#B8976A] to-transparent mx-auto mb-8"></div>

          <p className="text-white/90 mb-14 text-xl lg:text-2xl max-w-3xl mx-auto leading-relaxed" style={{ fontWeight: 300 }}>
            Your exclusive gateway to real estate portfolio management, performance analytics, 
            and investment opportunities—crafted for discerning partners.
          </p>
          
          <div className="flex flex-col sm:flex-row gap-6 justify-center items-center">
            <button 
              onClick={onSignIn}
              className="group bg-gradient-to-r from-[#890706] to-[#6d0505] text-white px-12 py-5 hover:shadow-2xl hover:shadow-[#890706]/50 transition-all duration-500 flex items-center gap-3 relative overflow-hidden"
            >
              <span className="relative z-10 tracking-wide">Access Dashboard</span>
              <ArrowRight className="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300 relative z-10" />
              <div className="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
            </button>
            <button className="bg-transparent text-white px-12 py-5 border border-white/30 hover:border-[#B8976A] hover:bg-white/5 backdrop-blur-sm transition-all duration-300">
              <span className="tracking-wide">Request Access</span>
            </button>
          </div>

          <p className="text-white/40 mt-12 text-sm tracking-widest">
            FOR VERIFIED INVESTORS ONLY
          </p>
        </div>

        <div className="absolute bottom-12 left-1/2 transform -translate-x-1/2 z-10 animate-bounce cursor-pointer">
          <ChevronDown className="w-8 h-8 text-white/50" />
        </div>
      </section>

      {/* Stats Section - New Premium Addition */}
      <section className="py-20 bg-neutral-900 border-y border-[#B8976A]/20">
        <div className="max-w-7xl mx-auto px-6">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-12">
            {[
              { value: "$2.4B", label: "Assets Under Management" },
              { value: "500+", label: "Premium Properties" },
              { value: "15+", label: "Years of Excellence" },
              { value: "98%", label: "Investor Satisfaction" }
            ].map((stat, index) => (
              <div key={index} className="text-center group">
                <div className="text-5xl lg:text-6xl mb-3 bg-gradient-to-br from-[#B8976A] to-[#8d7555] bg-clip-text text-transparent" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 300 }}>
                  {stat.value}
                </div>
                <div className="text-neutral-400 tracking-widest text-sm">{stat.label}</div>
                <div className="w-12 h-px bg-gradient-to-r from-transparent via-[#B8976A]/50 to-transparent mx-auto mt-4 group-hover:w-24 transition-all duration-500"></div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Trust Indicators - Enhanced */}
      <section className="py-28 bg-white relative">
        <div className="absolute top-0 left-1/2 w-px h-full bg-gradient-to-b from-transparent via-neutral-200 to-transparent"></div>
        <div className="max-w-7xl mx-auto px-6">
          <div className="text-center mb-20">
            <h2 className="text-5xl lg:text-6xl mb-4 text-neutral-900" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 300 }}>
              Built on <span className="italic">Trust</span>
            </h2>
            <div className="w-24 h-px bg-gradient-to-r from-transparent via-[#890706] to-transparent mx-auto"></div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-16 lg:gap-20">
            {[
              {
                icon: Shield,
                title: "Secure",
                description: "Bank-grade encryption and multi-factor authentication protecting every transaction and interaction."
              },
              {
                icon: Eye,
                title: "Transparent",
                description: "Real-time access to complete portfolio data, performance metrics, and comprehensive reporting."
              },
              {
                icon: TrendingUp,
                title: "Exclusive",
                description: "Purpose-built for high-net-worth individuals with dedicated support and premium features."
              }
            ].map((item, index) => (
              <div key={index} className="text-center group relative">
                <div className="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#890706] to-[#5d0505] mb-8 relative group-hover:scale-110 transition-transform duration-500">
                  <item.icon className="w-10 h-10 text-white" strokeWidth={1.5} />
                  <div className="absolute -inset-2 border border-[#890706]/20 group-hover:border-[#B8976A]/40 transition-colors duration-500"></div>
                </div>
                <h3 className="mb-4 text-neutral-900 text-3xl" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 400 }}>
                  {item.title}
                </h3>
                <p className="text-neutral-600 leading-relaxed text-lg" style={{ fontWeight: 300 }}>
                  {item.description}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Features - Premium Grid */}
      <section className="py-28 bg-neutral-50 relative overflow-hidden">
        <div className="absolute top-0 right-0 w-96 h-96 bg-[#B8976A]/5 rounded-full blur-3xl"></div>
        <div className="absolute bottom-0 left-0 w-96 h-96 bg-[#890706]/5 rounded-full blur-3xl"></div>
        
        <div className="max-w-7xl mx-auto px-6 relative z-10">
          <div className="text-center mb-20">
            <h2 className="text-5xl lg:text-6xl mb-6 text-neutral-900" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 300 }}>
              Your Investment <span className="italic">Command Center</span>
            </h2>
            <p className="text-neutral-600 text-xl max-w-3xl mx-auto" style={{ fontWeight: 300 }}>
              Every tool you need to monitor, manage, and maximize your real estate portfolio.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {[
              {
                icon: TrendingUp,
                title: "Portfolio Analytics",
                description: "Comprehensive dashboards with real-time performance tracking, asset allocation insights, and predictive analytics powered by market intelligence."
              },
              {
                icon: Eye,
                title: "Exclusive Opportunities",
                description: "First access to pre-market listings, off-market deals, and carefully vetted investment opportunities with detailed prospectus documentation."
              },
              {
                icon: FileText,
                title: "Document Vault",
                description: "Secure, encrypted repository for all contracts, reports, tax documents, and legal agreements—accessible anytime, anywhere."
              },
              {
                icon: Shield,
                title: "Private Messaging",
                description: "End-to-end encrypted communication with your dedicated account manager and our executive investment team."
              },
              {
                icon: Lock,
                title: "Performance Reports",
                description: "Quarterly earnings statements, ROI calculations, cash flow projections, and comparative market analysis delivered on schedule."
              },
              {
                icon: TrendingUp,
                title: "Market Intelligence",
                description: "Proprietary research, trend analysis, and market forecasts from our in-house team of real estate experts and economists."
              }
            ].map((feature, index) => (
              <div 
                key={index} 
                className="group bg-white p-10 hover:shadow-2xl transition-all duration-500 border border-neutral-200 hover:border-[#890706]/20 relative overflow-hidden"
              >
                <div className="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#890706]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-bl-full"></div>
                
                <div className="w-16 h-16 bg-neutral-50 group-hover:bg-gradient-to-br group-hover:from-[#890706] group-hover:to-[#5d0505] flex items-center justify-center mb-8 transition-all duration-500 relative z-10">
                  <feature.icon className="w-8 h-8 text-[#890706] group-hover:text-white transition-colors duration-500" strokeWidth={1.5} />
                </div>
                
                <h3 className="mb-4 text-neutral-900 text-2xl relative z-10" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 400 }}>
                  {feature.title}
                </h3>
                
                <p className="text-neutral-600 leading-relaxed relative z-10" style={{ fontWeight: 300 }}>
                  {feature.description}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* How It Works - Elegant Timeline */}
      <section className="py-28 bg-white">
        <div className="max-w-6xl mx-auto px-6">
          <div className="text-center mb-20">
            <h2 className="text-5xl lg:text-6xl mb-6 text-neutral-900" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 300 }}>
              Your Journey <span className="italic">Begins Here</span>
            </h2>
            <div className="w-24 h-px bg-gradient-to-r from-transparent via-[#890706] to-transparent mx-auto"></div>
          </div>

          <div className="relative">
            {/* Timeline Line */}
            <div className="absolute left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-[#B8976A] via-[#890706] to-[#B8976A] hidden lg:block"></div>

            <div className="space-y-24">
              {[
                {
                  number: "01",
                  title: "Investor Verification",
                  description: "Our team conducts a thorough verification process and creates your personalized account with role-specific permissions tailored to your investment portfolio."
                },
                {
                  number: "02",
                  title: "Secure Access",
                  description: "Receive your credentials and access the platform using enterprise-grade multi-factor authentication designed specifically for high-value accounts."
                },
                {
                  number: "03",
                  title: "Portfolio Command",
                  description: "Monitor investments in real-time, access exclusive opportunities, review detailed reports, and communicate directly with our executive team."
                }
              ].map((step, index) => (
                <div 
                  key={index} 
                  className={`flex flex-col lg:flex-row items-center gap-8 ${index % 2 === 1 ? 'lg:flex-row-reverse' : ''}`}
                >
                  <div className="flex-1 text-center lg:text-right" style={index % 2 === 1 ? { textAlign: 'left' } : {}}>
                    <div className="text-8xl mb-4 bg-gradient-to-br from-[#B8976A] to-[#8d7555] bg-clip-text text-transparent opacity-50" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 300 }}>
                      {step.number}
                    </div>
                    <h3 className="text-3xl mb-4 text-neutral-900" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 400 }}>
                      {step.title}
                    </h3>
                    <p className="text-neutral-600 leading-relaxed text-lg max-w-md" style={{ fontWeight: 300, margin: index % 2 === 1 ? '0' : '0 0 0 auto' }}>
                      {step.description}
                    </p>
                  </div>

                  <div className="relative flex-shrink-0">
                    <div className="w-6 h-6 bg-gradient-to-br from-[#890706] to-[#5d0505] rounded-full border-4 border-white shadow-xl"></div>
                    <div className="absolute inset-0 w-6 h-6 bg-[#890706] rounded-full animate-ping opacity-20"></div>
                  </div>

                  <div className="flex-1"></div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Security - Luxury Split */}
      <section className="py-28 bg-neutral-900 relative overflow-hidden">
        <div className="absolute inset-0 opacity-10">
          <div className="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-bl from-[#B8976A] to-transparent"></div>
        </div>

        <div className="max-w-7xl mx-auto px-6 relative z-10">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div>
              <h2 className="text-5xl lg:text-6xl mb-8 text-white" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 300 }}>
                Fortress-Grade <span className="italic">Security</span>
              </h2>
              
              <div className="w-24 h-px bg-gradient-to-r from-[#B8976A] to-transparent mb-12"></div>

              <p className="text-neutral-300 text-xl mb-12 leading-relaxed" style={{ fontWeight: 300 }}>
                Your investment data deserves military-grade protection. Our infrastructure implements the highest security standards in the financial industry.
              </p>

              <div className="space-y-8">
                {[
                  {
                    icon: Lock,
                    title: "256-Bit Encryption",
                    description: "All data encrypted in transit and at rest using AES-256, the same standard used by global financial institutions."
                  },
                  {
                    icon: Shield,
                    title: "Zero-Trust Architecture",
                    description: "Role-based permissions ensure each investor accesses only their portfolio data with multi-layered verification."
                  },
                  {
                    icon: Eye,
                    title: "Complete Audit Trails",
                    description: "Every action logged and monitored with real-time threat detection and automated response systems."
                  },
                  {
                    icon: FileText,
                    title: "Privacy Guarantee",
                    description: "Your data never leaves our secure servers and is protected under strict confidentiality agreements."
                  }
                ].map((item, index) => (
                  <div key={index} className="flex gap-6 group">
                    <div className="flex-shrink-0 w-14 h-14 bg-neutral-800 group-hover:bg-gradient-to-br group-hover:from-[#890706] group-hover:to-[#5d0505] flex items-center justify-center transition-all duration-500">
                      <item.icon className="w-7 h-7 text-[#B8976A] group-hover:text-white transition-colors duration-500" strokeWidth={1.5} />
                    </div>
                    <div>
                      <h4 className="mb-2 text-white text-xl" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 400 }}>
                        {item.title}
                      </h4>
                      <p className="text-neutral-400 leading-relaxed" style={{ fontWeight: 300 }}>
                        {item.description}
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            <div className="relative">
              <div className="aspect-[3/4] overflow-hidden shadow-2xl relative">
                <ImageWithFallback
                  src="https://images.unsplash.com/photo-1765371513492-264506c3ad09?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxleGVjdXRpdmUlMjBvZmZpY2UlMjBpbnRlcmlvcnxlbnwxfHx8fDE3Njc2MjI4Njl8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                  alt="Executive office"
                  className="w-full h-full object-cover"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-neutral-900 via-transparent to-transparent"></div>
              </div>
              <div className="absolute -bottom-8 -right-8 w-64 h-64 border border-[#B8976A]/20"></div>
              <div className="absolute -top-8 -left-8 w-32 h-32 bg-gradient-to-br from-[#890706] to-[#5d0505] opacity-50"></div>
            </div>
          </div>
        </div>
      </section>

      {/* Footer - Elegant */}
      <footer className="bg-black text-white py-20 border-t border-[#B8976A]/20">
        <div className="max-w-7xl mx-auto px-6">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <div className="md:col-span-2">
              <div className="mb-6">
                <ImageWithFallback
                  src="https://umera.ng/wp-content/uploads/2020/11/umera-logo.png"
                  alt="Uméra Logo"
                  className="h-12 w-auto object-contain brightness-0 invert opacity-90"
                />
              </div>
              <p className="text-neutral-400 leading-relaxed mb-6 max-w-md" style={{ fontWeight: 300 }}>
                A premium investment platform by Omera Palms, dedicated to providing high-net-worth individuals with unparalleled access to real estate opportunities.
              </p>
            </div>

            <div>
              <h4 className="mb-6 text-white" style={{ fontFamily: 'Cormorant Garamond, serif', fontSize: '1.25rem' }}>Access</h4>
              <ul className="space-y-3 text-neutral-400" style={{ fontWeight: 300 }}>
                <li><a href="#" className="hover:text-[#B8976A] transition-colors">Investor Login</a></li>
                <li><a href="#" className="hover:text-[#B8976A] transition-colors">Request Access</a></li>
                <li><a href="#" className="hover:text-[#B8976A] transition-colors">Support Center</a></li>
                <li><a href="#" className="hover:text-[#B8976A] transition-colors">Documentation</a></li>
              </ul>
            </div>

            <div>
              <h4 className="mb-6 text-white" style={{ fontFamily: 'Cormorant Garamond, serif', fontSize: '1.25rem' }}>Legal</h4>
              <ul className="space-y-3 text-neutral-400" style={{ fontWeight: 300 }}>
                <li><a href="#" className="hover:text-[#B8976A] transition-colors">Privacy Policy</a></li>
                <li><a href="#" className="hover:text-[#B8976A] transition-colors">Terms of Service</a></li>
                <li><a href="#" className="hover:text-[#B8976A] transition-colors">Security</a></li>
                <li><a href="#" className="hover:text-[#B8976A] transition-colors">Compliance</a></li>
              </ul>
            </div>
          </div>

          <div className="pt-8 border-t border-neutral-800 flex flex-col md:flex-row justify-between items-center gap-4">
            <p className="text-neutral-500 text-sm" style={{ fontWeight: 300 }}>
              © 2026 Uméra / Omera Palms. All rights reserved.
            </p>
            <p className="text-neutral-600 text-xs tracking-wider">
              FOR ACCREDITED INVESTORS ONLY
            </p>
          </div>
        </div>
      </footer>
    </div>
  );
}
import { ArrowRight } from "lucide-react";
import { ImageWithFallback } from "./figma/ImageWithFallback";

export function Hero() {
  return (
    <section className="relative min-h-screen flex items-center justify-center overflow-hidden">
      {/* Background Image with Overlay */}
      <div className="absolute inset-0 z-0">
        <ImageWithFallback
          src="https://images.unsplash.com/photo-1736939675530-d50e0a11b6f6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjBjb3Jwb3JhdGUlMjBidWlsZGluZ3xlbnwxfHx8fDE3Njc1NjAwNTB8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
          alt="Corporate building"
          className="w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-black/60"></div>
      </div>

      {/* Navigation */}
      <nav className="absolute top-0 left-0 right-0 z-20 px-6 py-6 lg:px-12">
        <div className="max-w-7xl mx-auto flex items-center justify-between">
          <div className="flex items-center space-x-2">
            <div className="w-10 h-10 bg-[#890706] flex items-center justify-center">
              <span className="text-white font-semibold text-xl">U</span>
            </div>
            <span className="text-white text-xl tracking-wide">Uméra</span>
          </div>
          <button className="text-white hover:text-[#B8976A] transition-colors px-6 py-2 border border-white/30 hover:border-[#B8976A] duration-300">
            Investor Login
          </button>
        </div>
      </nav>

      {/* Hero Content */}
      <div className="relative z-10 max-w-5xl mx-auto px-6 text-center">
        <h1 className="text-white mb-6 text-5xl lg:text-6xl tracking-tight max-w-4xl mx-auto">
          Investment Clarity. Complete Transparency.
        </h1>
        <p className="text-white/90 mb-12 text-xl lg:text-2xl max-w-3xl mx-auto leading-relaxed">
          Secure access to your real estate portfolio, performance metrics, and investment opportunities — designed exclusively for Uméra partners.
        </p>
        
        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <button className="bg-[#890706] text-white px-10 py-4 hover:bg-[#6d0505] transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-2 group min-w-[200px] justify-center">
            Investor Login
            <ArrowRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
          </button>
          <button className="bg-transparent text-white px-10 py-4 border-2 border-white/40 hover:border-[#B8976A] hover:bg-white/5 transition-all duration-300 min-w-[200px]">
            Request Access
          </button>
        </div>

        <p className="text-white/60 mt-8 text-sm">
          Secure portal for verified investors only
        </p>
      </div>

      {/* Scroll Indicator */}
      <div className="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
        <div className="w-6 h-10 border-2 border-white/40 rounded-full flex items-start justify-center p-2">
          <div className="w-1 h-3 bg-white/60 rounded-full"></div>
        </div>
      </div>
    </section>
  );
}

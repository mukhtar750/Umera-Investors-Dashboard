import { useState } from "react";
import { ArrowLeft, Lock, Eye, EyeOff, Shield, AlertCircle } from "lucide-react";
import { ImageWithFallback } from "./figma/ImageWithFallback";

interface SignInPageProps {
  onBack: () => void;
}

export function SignInPage({ onBack }: SignInPageProps) {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [showPassword, setShowPassword] = useState(false);
  const [rememberMe, setRememberMe] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState("");

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setError("");
    setIsLoading(true);
    
    // Simulate authentication
    setTimeout(() => {
      setIsLoading(false);
      setError("Invalid credentials. Please contact your account manager.");
    }, 1500);
  };

  return (
    <div className="min-h-screen grid grid-cols-1 lg:grid-cols-2" style={{ fontFamily: 'Inter, sans-serif' }}>
      {/* Left Side - Sign In Form */}
      <div className="flex flex-col justify-center px-8 sm:px-12 lg:px-20 xl:px-32 py-12 bg-white relative">
        {/* Back Button */}
        <button
          onClick={onBack}
          className="absolute top-8 left-8 flex items-center gap-2 text-neutral-600 hover:text-[#890706] transition-colors group"
        >
          <ArrowLeft className="w-5 h-5 group-hover:-translate-x-1 transition-transform" />
          <span style={{ fontWeight: 300 }}>Back to home</span>
        </button>

        {/* Logo */}
        <div className="mb-12">
          <ImageWithFallback
            src="https://umera.ng/wp-content/uploads/2020/11/umera-logo.png"
            alt="Uméra Logo"
            className="h-16 w-auto object-contain mb-4"
          />
        </div>

        {/* Form Header */}
        <div className="mb-10">
          <h1 className="text-4xl lg:text-5xl mb-4 text-neutral-900" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 300 }}>
            Welcome Back
          </h1>
          <p className="text-neutral-600 text-lg" style={{ fontWeight: 300 }}>
            Access your investment portfolio
          </p>
          <div className="w-16 h-px bg-gradient-to-r from-[#890706] to-transparent mt-4"></div>
        </div>

        {/* Error Message */}
        {error && (
          <div className="mb-6 p-4 bg-red-50 border border-red-200 flex items-start gap-3">
            <AlertCircle className="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" />
            <div>
              <p className="text-red-800 text-sm">{error}</p>
            </div>
          </div>
        )}

        {/* Sign In Form */}
        <form onSubmit={handleSubmit} className="space-y-6">
          {/* Email Field */}
          <div className="group">
            <label className="block mb-2 text-neutral-700" style={{ fontWeight: 400 }}>
              Email Address
            </label>
            <input
              type="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="investor@example.com"
              required
              className="w-full px-5 py-4 bg-neutral-50 border border-neutral-300 focus:border-[#890706] focus:bg-white transition-all duration-300 outline-none text-neutral-900"
              style={{ fontWeight: 300 }}
            />
          </div>

          {/* Password Field */}
          <div className="group">
            <label className="block mb-2 text-neutral-700" style={{ fontWeight: 400 }}>
              Password
            </label>
            <div className="relative">
              <input
                type={showPassword ? "text" : "password"}
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                placeholder="Enter your password"
                required
                className="w-full px-5 py-4 pr-12 bg-neutral-50 border border-neutral-300 focus:border-[#890706] focus:bg-white transition-all duration-300 outline-none text-neutral-900"
                style={{ fontWeight: 300 }}
              />
              <button
                type="button"
                onClick={() => setShowPassword(!showPassword)}
                className="absolute right-4 top-1/2 transform -translate-y-1/2 text-neutral-500 hover:text-[#890706] transition-colors"
              >
                {showPassword ? (
                  <EyeOff className="w-5 h-5" />
                ) : (
                  <Eye className="w-5 h-5" />
                )}
              </button>
            </div>
          </div>

          {/* Remember Me & Forgot Password */}
          <div className="flex items-center justify-between">
            <label className="flex items-center gap-2 cursor-pointer group">
              <input
                type="checkbox"
                checked={rememberMe}
                onChange={(e) => setRememberMe(e.target.checked)}
                className="w-4 h-4 accent-[#890706] cursor-pointer"
              />
              <span className="text-neutral-600 text-sm group-hover:text-neutral-900 transition-colors" style={{ fontWeight: 300 }}>
                Remember me
              </span>
            </label>
            <a href="#" className="text-sm text-[#890706] hover:text-[#6d0505] transition-colors" style={{ fontWeight: 400 }}>
              Forgot password?
            </a>
          </div>

          {/* Submit Button */}
          <button
            type="submit"
            disabled={isLoading}
            className="w-full bg-gradient-to-r from-[#890706] to-[#6d0505] text-white px-8 py-5 hover:shadow-2xl hover:shadow-[#890706]/30 transition-all duration-500 flex items-center justify-center gap-3 group relative overflow-hidden disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {isLoading ? (
              <>
                <div className="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                <span className="tracking-wide" style={{ fontWeight: 500 }}>Signing in...</span>
              </>
            ) : (
              <>
                <Lock className="w-5 h-5" />
                <span className="tracking-wide" style={{ fontWeight: 500 }}>Access Dashboard</span>
              </>
            )}
            <div className="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
          </button>

          {/* Security Badge */}
          <div className="pt-6 border-t border-neutral-200">
            <div className="flex items-center gap-3 text-neutral-500 text-sm">
              <Shield className="w-5 h-5 text-[#B8976A]" />
              <span style={{ fontWeight: 300 }}>
                Your connection is encrypted with 256-bit SSL
              </span>
            </div>
          </div>
        </form>

        {/* Additional Info */}
        <div className="mt-12 pt-8 border-t border-neutral-200">
          <p className="text-neutral-600 text-sm mb-4" style={{ fontWeight: 300 }}>
            Don't have access yet?
          </p>
          <a 
            href="#" 
            className="inline-flex items-center gap-2 text-[#890706] hover:text-[#6d0505] transition-colors group"
            style={{ fontWeight: 400 }}
          >
            Contact your account manager
            <span className="group-hover:translate-x-1 transition-transform">→</span>
          </a>
        </div>

        {/* Footer Note */}
        <div className="mt-12 text-center">
          <p className="text-neutral-400 text-xs tracking-wider">
            FOR VERIFIED INVESTORS ONLY
          </p>
        </div>
      </div>

      {/* Right Side - Visual */}
      <div className="hidden lg:block relative bg-neutral-900 overflow-hidden">
        {/* Background Image */}
        <div className="absolute inset-0">
          <ImageWithFallback
            src="https://images.unsplash.com/photo-1736939675530-d50e0a11b6f6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjBjb3Jwb3JhdGUlMjBidWlsZGluZ3xlbnwxfHx8fDE3Njc1NjAwNTB8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
            alt="Luxury building"
            className="w-full h-full object-cover scale-110"
          />
          <div className="absolute inset-0 bg-gradient-to-br from-[#890706]/90 via-neutral-900/80 to-black/90"></div>
          <div className="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,transparent_0%,rgba(0,0,0,0.5)_100%)]"></div>
        </div>

        {/* Content Overlay */}
        <div className="relative z-10 h-full flex flex-col justify-center px-12 xl:px-20">
          <div className="mb-8">
            <div className="inline-block px-4 py-2 bg-white/10 border border-white/20 backdrop-blur-sm mb-6">
              <span className="text-[#B8976A] tracking-widest text-sm">SECURE ACCESS</span>
            </div>
          </div>

          <h2 className="text-5xl xl:text-6xl mb-8 text-white leading-tight" style={{ fontFamily: 'Cormorant Garamond, serif', fontWeight: 300 }}>
            Your Portfolio,<br />
            <span className="italic" style={{ fontWeight: 400 }}>Always Accessible</span>
          </h2>

          <div className="w-24 h-px bg-gradient-to-r from-[#B8976A] to-transparent mb-8"></div>

          <p className="text-white/80 text-xl mb-12 max-w-md leading-relaxed" style={{ fontWeight: 300 }}>
            Access real-time analytics, exclusive opportunities, and comprehensive reports from anywhere in the world.
          </p>

          {/* Feature List */}
          <div className="space-y-6">
            {[
              "Real-time portfolio monitoring",
              "Secure document access",
              "Direct team communication",
              "Exclusive investment insights"
            ].map((feature, index) => (
              <div key={index} className="flex items-center gap-4 group">
                <div className="w-1.5 h-1.5 bg-[#B8976A] group-hover:scale-150 transition-transform duration-300"></div>
                <span className="text-white/90 group-hover:text-white transition-colors" style={{ fontWeight: 300 }}>
                  {feature}
                </span>
              </div>
            ))}
          </div>

          {/* Stats */}
          <div className="grid grid-cols-3 gap-8 mt-16 pt-12 border-t border-white/10">
            {[
              { value: "256-bit", label: "Encryption" },
              { value: "24/7", label: "Access" },
              { value: "100%", label: "Secure" }
            ].map((stat, index) => (
              <div key={index}>
                <div className="text-3xl mb-2 text-[#B8976A]" style={{ fontFamily: 'Cormorant Garamond, serif' }}>
                  {stat.value}
                </div>
                <div className="text-white/60 text-sm tracking-wider">{stat.label}</div>
              </div>
            ))}
          </div>
        </div>

        {/* Decorative Elements */}
        <div className="absolute top-20 right-20 w-64 h-64 border border-white/10 rotate-45"></div>
        <div className="absolute bottom-20 left-20 w-32 h-32 bg-gradient-to-br from-[#B8976A]/20 to-transparent"></div>
      </div>
    </div>
  );
}
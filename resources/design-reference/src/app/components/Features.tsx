import { TrendingUp, FileText, Shield, Lock, Eye } from "lucide-react";

export function Features() {
  const features = [
    {
      icon: TrendingUp,
      title: "Portfolio Overview",
      description: "Comprehensive view of all your real estate investments, asset allocations, and performance metrics in one centralized dashboard."
    },
    {
      icon: Eye,
      title: "Investment Opportunities",
      description: "Early access to exclusive real estate opportunities vetted by our investment team, with detailed prospectus and analysis."
    },
    {
      icon: FileText,
      title: "Documents & Reports",
      description: "Secure access to quarterly reports, tax documents, legal agreements, and property documentation — available 24/7."
    },
    {
      icon: Shield,
      title: "Secure Communication",
      description: "Encrypted messaging with your account manager and our investment team for confidential discussions and inquiries."
    },
    {
      icon: Lock,
      title: "Performance Tracking",
      description: "Real-time analytics, historical performance data, cash flow projections, and detailed ROI calculations for every investment."
    }
  ];

  return (
    <section className="py-24 bg-white">
      <div className="max-w-7xl mx-auto px-6">
        <div className="text-center mb-16">
          <h2 className="mb-4 text-neutral-900 text-4xl lg:text-5xl">What the Dashboard Provides</h2>
          <p className="text-neutral-600 text-xl max-w-2xl mx-auto">
            Everything you need to monitor and manage your real estate investments with complete confidence.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {features.map((feature, index) => (
            <div 
              key={index} 
              className="p-8 border border-neutral-200 hover:border-[#890706] transition-all duration-300 hover:shadow-lg group"
            >
              <div className="w-14 h-14 bg-neutral-100 group-hover:bg-[#890706] flex items-center justify-center mb-6 transition-colors duration-300">
                <feature.icon className="w-7 h-7 text-[#890706] group-hover:text-white transition-colors duration-300" strokeWidth={1.5} />
              </div>
              <h3 className="mb-3 text-neutral-900 text-xl">{feature.title}</h3>
              <p className="text-neutral-600 leading-relaxed">{feature.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

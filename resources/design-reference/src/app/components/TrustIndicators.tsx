import { Shield, Eye, TrendingUp } from "lucide-react";

export function TrustIndicators() {
  const indicators = [
    {
      icon: Shield,
      title: "Secure",
      description: "Bank-level encryption and role-based access controls"
    },
    {
      icon: Eye,
      title: "Transparent",
      description: "Real-time access to your complete investment portfolio"
    },
    {
      icon: TrendingUp,
      title: "Investor-Focused",
      description: "Built exclusively for high-net-worth partners"
    }
  ];

  return (
    <section className="py-20 bg-neutral-50 border-t border-neutral-200">
      <div className="max-w-7xl mx-auto px-6">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-16">
          {indicators.map((item, index) => (
            <div key={index} className="text-center">
              <div className="inline-flex items-center justify-center w-16 h-16 bg-[#890706] mb-6">
                <item.icon className="w-8 h-8 text-white" strokeWidth={1.5} />
              </div>
              <h3 className="mb-3 text-neutral-900 text-2xl">{item.title}</h3>
              <p className="text-neutral-600 leading-relaxed">{item.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

export function HowItWorks() {
  const steps = [
    {
      number: "01",
      title: "Investor Onboarding",
      description: "Our team verifies your investment and creates your secure account with personalized access credentials and permissions."
    },
    {
      number: "02",
      title: "Secure Login",
      description: "Access your dashboard using multi-factor authentication and role-based security protocols designed for investor protection."
    },
    {
      number: "03",
      title: "Track & Manage",
      description: "Monitor your investments in real-time, review reports, access documents, and communicate with our team — all in one platform."
    }
  ];

  return (
    <section className="py-24 bg-neutral-50">
      <div className="max-w-7xl mx-auto px-6">
        <div className="text-center mb-16">
          <h2 className="mb-4 text-neutral-900 text-4xl lg:text-5xl">How It Works</h2>
          <p className="text-neutral-600 text-xl max-w-2xl mx-auto">
            A streamlined process designed for security and ease of access.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
          {steps.map((step, index) => (
            <div key={index} className="relative">
              <div className="flex flex-col items-center text-center">
                <div className="w-20 h-20 border-2 border-[#890706] flex items-center justify-center mb-6">
                  <span className="text-4xl text-[#890706]">{step.number}</span>
                </div>
                <h3 className="mb-4 text-neutral-900 text-2xl">{step.title}</h3>
                <p className="text-neutral-600 leading-relaxed">{step.description}</p>
              </div>
              
              {/* Connector line for desktop */}
              {index < steps.length - 1 && (
                <div className="hidden md:block absolute top-10 left-[60%] w-[80%] h-[2px] bg-neutral-300">
                  <div className="absolute right-0 top-1/2 transform -translate-y-1/2 w-0 h-0 border-l-8 border-l-neutral-300 border-t-4 border-t-transparent border-b-4 border-b-transparent"></div>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

import { Shield, Lock, Eye, FileText } from "lucide-react";
import { ImageWithFallback } from "./figma/ImageWithFallback";

export function Security() {
  return (
    <section className="py-24 bg-white relative overflow-hidden">
      <div className="max-w-7xl mx-auto px-6">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          {/* Content */}
          <div>
            <h2 className="mb-6 text-neutral-900 text-4xl lg:text-5xl">Security & Privacy</h2>
            <p className="text-neutral-600 text-xl mb-10 leading-relaxed">
              Your investment data is protected by enterprise-grade security measures designed specifically for high-value portfolios and confidential financial information.
            </p>

            <div className="space-y-6">
              <div className="flex gap-4">
                <div className="flex-shrink-0 w-12 h-12 bg-neutral-100 flex items-center justify-center">
                  <Lock className="w-6 h-6 text-[#890706]" strokeWidth={1.5} />
                </div>
                <div>
                  <h4 className="mb-2 text-neutral-900">Bank-Level Encryption</h4>
                  <p className="text-neutral-600">All data is encrypted in transit and at rest using industry-standard 256-bit encryption protocols.</p>
                </div>
              </div>

              <div className="flex gap-4">
                <div className="flex-shrink-0 w-12 h-12 bg-neutral-100 flex items-center justify-center">
                  <Shield className="w-6 h-6 text-[#890706]" strokeWidth={1.5} />
                </div>
                <div>
                  <h4 className="mb-2 text-neutral-900">Role-Based Access Control</h4>
                  <p className="text-neutral-600">Each investor sees only their portfolio data with permissions tailored to their investment level.</p>
                </div>
              </div>

              <div className="flex gap-4">
                <div className="flex-shrink-0 w-12 h-12 bg-neutral-100 flex items-center justify-center">
                  <Eye className="w-6 h-6 text-[#890706]" strokeWidth={1.5} />
                </div>
                <div>
                  <h4 className="mb-2 text-neutral-900">Audit Trails</h4>
                  <p className="text-neutral-600">Comprehensive logging of all access and activities for complete transparency and compliance.</p>
                </div>
              </div>

              <div className="flex gap-4">
                <div className="flex-shrink-0 w-12 h-12 bg-neutral-100 flex items-center justify-center">
                  <FileText className="w-6 h-6 text-[#890706]" strokeWidth={1.5} />
                </div>
                <div>
                  <h4 className="mb-2 text-neutral-900">Confidential Data Handling</h4>
                  <p className="text-neutral-600">Your information is never shared with third parties and is protected under strict confidentiality agreements.</p>
                </div>
              </div>
            </div>
          </div>

          {/* Image */}
          <div className="relative">
            <div className="aspect-[4/3] overflow-hidden shadow-2xl">
              <ImageWithFallback
                src="https://images.unsplash.com/photo-1764722870670-ee5e9d4456f5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBhcmNoaXRlY3R1cmUlMjBpbnZlc3RtZW50fGVufDF8fHx8MTc2NzYyNTQzMnww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                alt="Modern architecture"
                className="w-full h-full object-cover"
              />
            </div>
            <div className="absolute -bottom-6 -right-6 w-48 h-48 bg-[#B8976A] opacity-10 -z-10"></div>
            <div className="absolute -top-6 -left-6 w-48 h-48 border-2 border-[#890706] opacity-20 -z-10"></div>
          </div>
        </div>
      </div>
    </section>
  );
}

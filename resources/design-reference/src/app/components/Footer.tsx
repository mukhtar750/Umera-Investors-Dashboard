export function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="bg-neutral-900 text-white py-12 border-t border-neutral-800">
      <div className="max-w-7xl mx-auto px-6">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
          {/* Brand */}
          <div>
            <div className="flex items-center space-x-2 mb-4">
              <div className="w-10 h-10 bg-[#890706] flex items-center justify-center">
                <span className="text-white font-semibold text-xl">U</span>
              </div>
              <span className="text-white text-xl tracking-wide">Uméra</span>
            </div>
            <p className="text-neutral-400 leading-relaxed">
              Uméra Investors Dashboard
            </p>
            <p className="text-neutral-400 text-sm mt-2">
              A division of Omera Palms
            </p>
          </div>

          {/* Links */}
          <div>
            <h4 className="mb-4 text-white">Investor Resources</h4>
            <ul className="space-y-2 text-neutral-400">
              <li>
                <a href="#" className="hover:text-[#B8976A] transition-colors">
                  Investor Login
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-[#B8976A] transition-colors">
                  Request Access
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-[#B8976A] transition-colors">
                  Support
                </a>
              </li>
            </ul>
          </div>

          {/* Legal */}
          <div>
            <h4 className="mb-4 text-white">Legal</h4>
            <ul className="space-y-2 text-neutral-400">
              <li>
                <a href="#" className="hover:text-[#B8976A] transition-colors">
                  Privacy Policy
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-[#B8976A] transition-colors">
                  Terms of Service
                </a>
              </li>
              <li>
                <a href="#" className="hover:text-[#B8976A] transition-colors">
                  Security
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div className="pt-8 border-t border-neutral-800 flex flex-col md:flex-row justify-between items-center gap-4">
          <p className="text-neutral-400 text-sm">
            © {currentYear} Uméra / Omera Palms. All rights reserved.
          </p>
          <p className="text-neutral-500 text-sm">
            For verified investors only
          </p>
        </div>
      </div>
    </footer>
  );
}

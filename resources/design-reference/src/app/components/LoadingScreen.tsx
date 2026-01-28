export function LoadingScreen() {
  return (
    <div className="fixed inset-0 bg-white z-50 flex items-center justify-center">
      <div className="text-center">
        {/* Logo */}
        <div className="flex items-center justify-center mb-8">
          <div className="relative">
            <div className="w-20 h-20 bg-gradient-to-br from-[#890706] to-[#5d0505] flex items-center justify-center shadow-2xl">
              <span className="text-white font-bold text-4xl" style={{ fontFamily: 'Cormorant Garamond, serif' }}>U</span>
            </div>
            <div className="absolute -bottom-2 -right-2 w-4 h-4 bg-[#B8976A] rounded-full animate-pulse"></div>
          </div>
        </div>

        {/* Loading Animation */}
        <div className="flex gap-2 justify-center mb-6">
          {[0, 1, 2].map((i) => (
            <div
              key={i}
              className="w-2 h-2 bg-gradient-to-r from-[#890706] to-[#B8976A] rounded-full animate-pulse"
              style={{ animationDelay: `${i * 0.2}s` }}
            />
          ))}
        </div>

        <p className="text-neutral-400 tracking-widest text-sm">
          LOADING
        </p>
      </div>
    </div>
  );
}

import { useState } from "react";
import { LandingPage } from "./components/LandingPage";
import { SignInPage } from "./components/SignInPage";

export default function App() {
  const [showSignIn, setShowSignIn] = useState(false);

  return (
    <div className="min-h-screen">
      {showSignIn ? (
        <SignInPage onBack={() => setShowSignIn(false)} />
      ) : (
        <LandingPage onSignIn={() => setShowSignIn(true)} />
      )}
    </div>
  );
}

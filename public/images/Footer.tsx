import Image from "next/image";
import Link from "next/link";

export default function Footer(): React.ReactElement {
  return (
    <footer>
      {/* ── PARTIE BLANCHE ── */}
      <div className="bg-white px-16 py-14 grid grid-cols-5 gap-8">

        {/* Colonne 1 — Brand */}
        <div className="col-span-1 flex flex-col gap-5">
          <h2 className="text-2xl font-bold text-gray-900">Kniyot</h2>
          <p className="text-sm text-gray-500 leading-relaxed">
            Kniyot is an agri-industrial marketplace where producers,
            wholesalers, retailers, and restaurants buy and sell fresh
            agricultural products such as fruits, vegetables, greens, and
            grains with direct delivery.
          </p>
          <div className="flex flex-col gap-3 mt-2">
            <div className="flex items-center gap-2 text-sm text-gray-500">
              <Image src="/pin.svg" width={16} height={16} alt="location" />
              <span>Dakar, Sénégal</span>
            </div>
            <div className="flex items-center gap-2 text-sm text-gray-500">
              <Image src="/phone.svg" width={16} height={16} alt="phone" />
              <span>+221 77 000 00 00</span>
            </div>
            <div className="flex items-center gap-2 text-sm text-gray-500">
              <Image src="/mail.svg" width={16} height={16} alt="email" />
              <span>contact@kniyot.com</span>
            </div>
          </div>
        </div>

        {/* Colonne 2 — Categories */}
        <div className="col-span-1 flex flex-col gap-4">
          <h3 className="font-semibold text-gray-900">Categories</h3>
          <ul className="flex flex-col gap-2">
            {["Fruits", "Vegetables", "Meat & Poultry", "Dairy & Eggs"].map((item) => (
              <li key={item}>
                <Link href="#" className="text-sm text-gray-500 hover:text-primaryg transition-colors">
                  {item}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Colonne 3 — Support */}
        <div className="col-span-1 flex flex-col gap-4">
          <h3 className="font-semibold text-gray-900">Support</h3>
          <ul className="flex flex-col gap-2">
            {[
              "Help Center",
              "My Orders",
              "Shipping Information",
              "Returns & Exchanges",
              "Frequently Asked Questions",
              "Contact Us",
            ].map((item) => (
              <li key={item}>
                <Link href="#" className="text-sm text-gray-500 hover:text-primaryg transition-colors">
                  {item}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Colonne 4 — About Us */}
        <div className="col-span-1 flex flex-col gap-4">
          <h3 className="font-semibold text-gray-900">About Us</h3>
          <ul className="flex flex-col gap-2">
            {["Who We Are", "Sustainability", "Blog", "Press"].map((item) => (
              <li key={item}>
                <Link href="#" className="text-sm text-gray-500 hover:text-primaryg transition-colors">
                  {item}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Colonne 5 — Download & Social */}
        <div className="col-span-1 flex flex-col gap-6">
          <div className="flex flex-col gap-3">
            <h3 className="font-semibold text-gray-900">Download Our App</h3>
            <p className="text-sm text-gray-500">Shop more easily from your phone</p>
            <div className="flex flex-col gap-2">
              <Link href="#" className="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 hover:bg-gray-50 transition-colors w-fit">
                <span className="text-sm font-medium text-gray-700">🍎 App Store</span>
              </Link>
              <Link href="#" className="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 hover:bg-gray-50 transition-colors w-fit">
                <span className="text-sm font-medium text-gray-700">▶ Google Play</span>
              </Link>
            </div>
          </div>

          <div className="flex flex-col gap-3">
            <h3 className="font-semibold text-gray-900">Follow Us</h3>
            <div className="flex gap-3">
              {[
                { label: "f", href: "#" },
                { label: "ig", href: "#" },
                { label: "x", href: "#" },
                { label: "tt", href: "#" },
                { label: "p", href: "#" },
                { label: "yt", href: "#" },
              ].map(({ label, href }) => (
                <Link
                  key={label}
                  href={href}
                  className="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs text-gray-600 hover:bg-primaryg hover:text-white transition-all"
                >
                  {label}
                </Link>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* ── PARTIE GRISE ── */}
      <div className="bg-gray-100 px-16 py-6 flex flex-col items-center gap-4">
        {/* Moyens de paiement */}
        <div className="flex items-center gap-3 text-sm text-gray-500">
          <span className="font-medium">We accept:</span>
          <div className="flex gap-2 text-gray-400 text-lg">
            <span>💳</span>
            <span>🅿</span>
            <span>🍎</span>
            <span>G</span>
            <span>🏦</span>
          </div>
        </div>

        {/* Liens légaux */}
        <div className="flex gap-6">
          {["Terms of Service", "Privacy Policy", "Cookie Settings"].map((item) => (
            <Link key={item} href="#" className="text-xs text-gray-400 hover:text-gray-600 transition-colors">
              {item}
            </Link>
          ))}
        </div>

        {/* Copyright */}
        <div className="text-center">
          <p className="text-xs text-gray-400">
            © Copyright <span className="font-semibold text-gray-600">Kniyot</span>. All rights reserved.
          </p>
          <p className="text-xs text-gray-400 mt-1">
            Designed by{" "}
            <Link href="#" className="text-primaryg hover:underline">
              YourName
            </Link>
          </p>
        </div>
      </div>
    </footer>
  );
}

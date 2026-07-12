import Image from "next/image";
import Link from "next/link";

export default function Nav(): React.ReactElement {
  //--------------------------------SERA ADAPTE POUR ETRE UN CLIENT SIDE AUSSI CUZ REACT HOOKS-------------------------------------------------
  return (
    <>
      <div className="flex ml-90 text-sm w-full m-5">
        <nav className="mr-5 ">
          <Link
            href="#"
            className="relative after:content-[''] after:w-full after:h-[0.2px] after:bottom-[-2px] after:left-0 after:absolute after:bg-gray-500"
          >
            Home
          </Link>
        </nav>
        <nav className="mr-5">
          <Link href="#" className="line">
            About Us
          </Link>
        </nav>
        <nav className="mr-5">
          <Link href="#" className="line">
            Categories
          </Link>
        </nav>
        <nav className="mr-5">
          <Link href="#" className="line">
            Agros
          </Link>
        </nav>
        <nav className="mr-5">
          <Link href="#" className="line">
            Producers
          </Link>
        </nav>
        <nav className="mr-5">
          <Link href="#" className="line">
            Transport
          </Link>
        </nav>
        <nav className="mr-5">
          <Link href="#" className="line">
            Contacts
          </Link>
        </nav>
      </div>
      <div className="w-full h-9 bg-secondaryg text-white p-1 flex justify-center">
        <Image
          src={"truck.svg"}
          width={20}
          height={20}
          alt="phone"
          className="m-1 "
        />{" "}
        <span>Free shipping on qualifying orders</span>
      </div>
    </>
  );
}

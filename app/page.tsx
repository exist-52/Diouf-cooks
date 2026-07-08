import Image from "next/image";

export default function Home() {
  return (
    <>
      <div className="flex p-4 justify-center">
        {" "}
        {/*Big div wrapper */}
        <Image
          src={"/images/gromuse.png"}
          alt="logo"
          height={100}
          width={180}
          className="inline"
        />
        <div className="border-solid rounded-l-2xl">{/*searchbar div */}</div>
        <Image
          src={"pin.svg"}
          height={20}
          width={15}
          alt="pin"
          className="inline"
        />
        <span>Your location</span>
        <span>
          <input placeholder="search products..."></input>
        </span>
        <span className="bg-primaryg">
          <Image
            src={"search.svg"}
            height={20}
            width={15}
            alt="pin"
            className="inline"
          />
        </span>
        <span>
          <span className="p-1">
            <Image
              src={"cart.svg"}
              height={15}
              width={20}
              alt="pin"
              className="inline"
            />
          </span>
          <span>Cart</span>
        </span>
        <span>
          <span className="p-1">
            <Image
              src={"person.svg"}
              height={15}
              width={20}
              alt="pin"
              className="inline"
            />
          </span>
          <span>My Account</span>
        </span>
      </div>
    </>
  );
}

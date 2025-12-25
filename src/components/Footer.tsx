import { motion } from "framer-motion";
import { Flame, Phone, Mail, MapPin, Facebook, Twitter, Linkedin, Instagram } from "lucide-react";
const quickLinks = [{
  name: "Home",
  href: "#home"
}, {
  name: "Services",
  href: "#services"
}, {
  name: "About Us",
  href: "#about"
}, {
  name: "Contact",
  href: "#contact"
}];
const services = ["Fire Extinguishers", "Alarm Systems", "Safety Training", "Risk Assessment", "System Maintenance", "Compliance Services"];
const socialLinks = [{
  icon: Facebook,
  href: "#"
}, {
  icon: Twitter,
  href: "#"
}, {
  icon: Linkedin,
  href: "#"
}, {
  icon: Instagram,
  href: "#"
}];
export const Footer = () => {
  return <footer className="bg-accent text-accent-foreground">
      {/* Main Footer */}
      <div className="container mx-auto px-4 lg:px-8 py-16">
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-12">
          {/* Brand */}
          <motion.div initial={{
          opacity: 0,
          y: 20
        }} whileInView={{
          opacity: 1,
          y: 0
        }} viewport={{
          once: true
        }} transition={{
          duration: 0.6
        }}>
            <a href="#home" className="flex items-center gap-2 mb-6">
              <div className="w-10 h-10 gradient-fire rounded-lg flex items-center justify-center">
                <Flame className="w-6 h-6 text-primary-foreground" />
              </div>
              <span className="font-display tracking-wider text-center text-base">
                YOU-SAFE FIR CORPORATION  
              </span>
            </a>
            <p className="text-accent-foreground/60 mb-6">
              Your trusted partner in fire safety since 1998. Protecting lives
              and properties with excellence.
            </p>
            <div className="flex gap-3">
              {socialLinks.map((social, index) => <a key={index} href={social.href} className="w-10 h-10 bg-accent-foreground/10 rounded-lg flex items-center justify-center hover:bg-primary hover:text-primary-foreground transition-colors">
                  <social.icon className="w-5 h-5" />
                </a>)}
            </div>
          </motion.div>

          {/* Quick Links */}
          <motion.div initial={{
          opacity: 0,
          y: 20
        }} whileInView={{
          opacity: 1,
          y: 0
        }} viewport={{
          once: true
        }} transition={{
          duration: 0.6,
          delay: 0.1
        }}>
            <h4 className="font-display text-xl mb-6 tracking-wide">
              QUICK LINKS
            </h4>
            <ul className="space-y-3">
              {quickLinks.map(link => <li key={link.name}>
                  <a href={link.href} className="text-accent-foreground/60 hover:text-fire-orange transition-colors">
                    {link.name}
                  </a>
                </li>)}
            </ul>
          </motion.div>

          {/* Services */}
          <motion.div initial={{
          opacity: 0,
          y: 20
        }} whileInView={{
          opacity: 1,
          y: 0
        }} viewport={{
          once: true
        }} transition={{
          duration: 0.6,
          delay: 0.2
        }}>
            <h4 className="font-display text-xl mb-6 tracking-wide">
              OUR SERVICES
            </h4>
            <ul className="space-y-3">
              {services.map(service => <li key={service}>
                  <a href="#services" className="text-accent-foreground/60 hover:text-fire-orange transition-colors">
                    {service}
                  </a>
                </li>)}
            </ul>
          </motion.div>

          {/* Contact Info */}
          <motion.div initial={{
          opacity: 0,
          y: 20
        }} whileInView={{
          opacity: 1,
          y: 0
        }} viewport={{
          once: true
        }} transition={{
          duration: 0.6,
          delay: 0.3
        }}>
            <h4 className="font-display text-xl mb-6 tracking-wide">
              CONTACT INFO
            </h4>
            <ul className="space-y-4">
              <li className="flex items-start gap-3">
                <MapPin className="w-5 h-5 text-fire-orange mt-0.5 flex-shrink-0" />
                <span className="text-accent-foreground/60">
                  123 Safety Street
                  <br />
                  Fire City, FC 12345
                </span>
              </li>
              <li className="flex items-center gap-3">
                <Phone className="w-5 h-5 text-fire-orange flex-shrink-0" />
                <a href="tel:=923139242996" className="text-accent-foreground/60 hover:text-fire-orange transition-colors">
                  +923139242996
                </a>
              </li>
              <li className="flex items-center gap-3">
                <Mail className="w-5 h-5 text-fire-orange flex-shrink-0" />
                <a href="mailto:muhib7192@gmail.com" className="text-accent-foreground/60 hover:text-fire-orange transition-colors">
                  muhib7192@gmail.com
                </a>
              </li>
            </ul>
          </motion.div>
        </div>
      </div>

      {/* Bottom Bar */}
      <div className="border-t border-accent-foreground/10">
        <div className="container mx-auto px-4 lg:px-8 py-6">
          <div className="flex flex-col md:flex-row justify-between items-center gap-4">
            <p className="text-accent-foreground/50 text-sm text-center md:text-left">
              © 2025 Eng:Muhib Ullah. All rights reserved.
            </p>
            <div className="flex gap-6">
              <a href="#" className="text-accent-foreground/50 hover:text-fire-orange text-sm transition-colors">
                Privacy Policy
              </a>
              <a href="#" className="text-accent-foreground/50 hover:text-fire-orange text-sm transition-colors">
                Terms of Service
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>;
};
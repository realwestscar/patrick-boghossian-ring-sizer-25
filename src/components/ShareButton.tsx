import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { ShareIcon, Copy, Check, FacebookIcon, TwitterIcon, InstagramIcon } from 'lucide-react';
import { toast } from 'sonner';
interface ShareButtonProps {
  ringSize: {
    diameterMm: number;
    us: string;
    uk: string;
    eu: string;
    jp: string;
  };
}
const ShareButton: React.FC<ShareButtonProps> = ({
  ringSize
}) => {
  const [copied, setCopied] = useState(false);
  const [showShareOptions, setShowShareOptions] = useState(false);
  const shareText = `I found my ring size using the Ring Sizer tool:
• US: ${ringSize.us}
• UK/AU: ${ringSize.uk}
• EU: ${ringSize.eu}
• JP/CN: ${ringSize.jp}
• Diameter: ${ringSize.diameterMm.toFixed(1)} mm`;
  const copyToClipboard = () => {
    navigator.clipboard.writeText(shareText);
    setCopied(true);
    toast.success('Ring size copied to clipboard!');
    setTimeout(() => setCopied(false), 2000);
  };
  const shareOnSocial = (platform: string) => {
    let url = '';
    const encodedText = encodeURIComponent(shareText);
    switch (platform) {
      case 'facebook':
        url = `https://www.facebook.com/sharer/sharer.php?u=${window.location.href}&quote=${encodedText}`;
        break;
      case 'twitter':
        url = `https://twitter.com/intent/tweet?text=${encodedText}&url=${window.location.href}`;
        break;
      case 'whatsapp':
        url = `https://wa.me/?text=${encodedText}`;
        break;
      default:
        break;
    }
    if (url) {
      window.open(url, '_blank');
    }
    setShowShareOptions(false);
    toast.success(`Shared on ${platform}!`);
  };
  return <motion.div className="w-full max-w-md mx-auto mt-8 mb-12" initial={{
    opacity: 0,
    y: 20
  }} animate={{
    opacity: 1,
    y: 0
  }} transition={{
    duration: 0.6,
    delay: 0.4
  }}>
      <div className="flex flex-col items-center">
        
        
        {showShareOptions && <motion.div className="glassmorphism p-4 rounded-lg w-full" initial={{
        opacity: 0,
        height: 0
      }} animate={{
        opacity: 1,
        height: 'auto'
      }} exit={{
        opacity: 0,
        height: 0
      }} transition={{
        duration: 0.3
      }}>
            <div className="flex justify-center gap-4 mb-4">
              <motion.button className="p-3 bg-[#3b5998] text-white rounded-full" whileHover={{
            scale: 1.1
          }} whileTap={{
            scale: 0.9
          }} onClick={() => shareOnSocial('facebook')}>
                <FacebookIcon size={20} />
              </motion.button>
              <motion.button className="p-3 bg-[#1DA1F2] text-white rounded-full" whileHover={{
            scale: 1.1
          }} whileTap={{
            scale: 0.9
          }} onClick={() => shareOnSocial('twitter')}>
                <TwitterIcon size={20} />
              </motion.button>
              <motion.button className="p-3 bg-gradient-to-r from-[#FCAF45] via-[#E1306C] to-[#5851DB] text-white rounded-full" whileHover={{
            scale: 1.1
          }} whileTap={{
            scale: 0.9
          }} onClick={() => shareOnSocial('instagram')}>
                <InstagramIcon size={20} />
              </motion.button>
            </div>
            
            <div className="flex items-center gap-2 glassmorphism p-2 rounded-full">
              <input type="text" value={shareText} readOnly className="flex-grow bg-transparent border-none focus:outline-none text-sm p-2 text-burgundy" />
              <motion.button className="p-2 bg-burgundy text-white rounded-full" onClick={copyToClipboard} whileHover={{
            scale: 1.05
          }} whileTap={{
            scale: 0.95
          }}>
                {copied ? <Check size={18} /> : <Copy size={18} />}
              </motion.button>
            </div>
          </motion.div>}
      </div>
    </motion.div>;
};
export default ShareButton;
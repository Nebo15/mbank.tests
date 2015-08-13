# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  #config.vm.box = "http://files.dryga.com/boxes/osx-yosemite-0.2.1.box"
  config.vm.box = "AndrewDryga/vagrant-box-osx"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.99.33"

  # Share an additional folder to the guest VM.
  config.vm.synced_folder ".", "/vagrant",
    id: "vagrant-root",
    :nfs => true,
    :mount_options => ['nolock,vers=3,udp,noatime']

  config.vm.provider "virtualbox" do |vb|
    # Display the VirtualBox GUI when booting the machine
    # vb.gui = true

    # Customize the amount of memory on the VM:
    # vb.memory = "1024"
    # Customize motherboard chipset
    # vb.customize ["modifyvm", :id, "--chipset", "ich9"]
    # Customize NAT DNS
    # v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    # v.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
  end

  # Don't insert random keypair instead of default keypair
  config.ssh.insert_key = false

  # Enable provisioning with a shell script.
  config.vm.provision "shell", inline: <<-SHELL
    sudo chown -R vagrant:admin /Library/Caches/Homebrew
    brew update
    npm update
    echo 'vagrant' | brew cask update
    sudo /usr/sbin/DevToolsSecurity --enable
    brew install php56
    php -v
  SHELL
end

PLUGIN := exode
DIST := dist
ARCHIVE := $(DIST)/$(PLUGIN).zip

INCLUDE := exode.php assets src vendor

.PHONY: all clean package

all: package

$(DIST):
	mkdir -p $(DIST)

package: $(DIST)
	# install only prod depts and opmtimize
	composer install --no-dev --optimize-autoloader
	zip -r $(ARCHIVE) $(INCLUDE)
	# re-install dev dependencies
	composer install

clean:
	rm -rf $(DIST)

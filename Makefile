PLUGIN := exode
DIST := dist
ARCHIVE := $(DIST)/$(PLUGIN).zip

INCLUDE := exode.php assets src

.PHONY: all clean package

all: package

$(DIST):
	mkdir -p $(DIST)

package: $(DIST)
	zip -r $(ARCHIVE) $(INCLUDE)

clean:
	rm -rf $(DIST)
